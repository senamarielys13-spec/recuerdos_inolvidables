
<?php

require_once __DIR__ . '/../config/Database.php';

class SolicitudContactoController
{
    private $conexion;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->conexion = $database->getConnection();
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido.');
        }

        // Verificar el formulario.
        $token = (string) ($_POST['csrf'] ?? '');
        $tokenSesion = (string) (
            $_SESSION['contacto_csrf'] ?? ''
        );

        if (
            $token === '' ||
            $tokenSesion === '' ||
            !hash_equals($tokenSesion, $token)
        ) {
            http_response_code(403);
            exit('Formulario no válido. Actualiza la página.');
        }

        $idProveedor = filter_var(
            $_POST['id_proveedor'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$idProveedor || $idProveedor < 1) {
            http_response_code(400);
            exit('Proveedor no válido.');
        }

        // Buscar el proveedor real en la base de datos.
        $consulta = $this->conexion->prepare(
            'SELECT nombre_comercial
             FROM proveedores
             WHERE id_proveedor = :id'
        );

        $consulta->execute([
            ':id' => $idProveedor
        ]);

        $proveedor = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$proveedor) {
            http_response_code(404);
            exit('El proveedor no existe.');
        }

        // Identificar al usuario cuando ha iniciado sesión.
        $idUsuario = !empty($_SESSION['user_id'])
            ? (int) $_SESSION['user_id']
            : null;

        $nombre = 'Visitante sin sesión';
        $email = '';
        $telefono = null;

        if ($idUsuario !== null) {
            $consultaUsuario = $this->conexion->prepare(
                'SELECT nombre, email, telefono
                 FROM usuarios
                 WHERE id_usuario = :id'
            );

            $consultaUsuario->execute([
                ':id' => $idUsuario
            ]);

            $usuario = $consultaUsuario->fetch(
                PDO::FETCH_ASSOC
            );

            if (!$usuario) {
                http_response_code(403);
                exit('La cuenta del usuario no existe.');
            }

            $nombre = $usuario['nombre'];
            $email = $usuario['email'];
            $telefono = $usuario['telefono'];
        }

        // Construir el mensaje que verá el usuario
        // cuando se abra WhatsApp.
        $mensaje =
            'Hola, estoy visitando Recuerdos Inolvidables '
            . 'y me interesa el servicio de '
            . $proveedor['nombre_comercial']
            . '. Quisiera solicitar información sobre '
            . 'precios, disponibilidad y condiciones. '
            . 'Muchas gracias.';

        // Registrar el intento de contacto.
        $sql =
            'INSERT INTO solicitudes_contacto
             (
                id_usuario,
                id_proveedor,
                nombre_remitente,
                email_remitente,
                telefono,
                mensaje
             )
             VALUES
             (
                :usuario,
                :proveedor,
                :nombre,
                :email,
                :telefono,
                :mensaje
             )';

        $guardar = $this->conexion->prepare($sql);

        $resultado = $guardar->execute([
            ':usuario' => $idUsuario,
            ':proveedor' => $idProveedor,
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':mensaje' => $mensaje
        ]);

        if (!$resultado) {
            http_response_code(500);
            exit('No fue posible registrar el contacto.');
        }

        // Abrir WhatsApp después de registrar el contacto.
        $numeroWhatsapp = '573132165342';

        $enlace =
            'https://wa.me/'
            . $numeroWhatsapp
            . '?text='
            . rawurlencode($mensaje);

        header('Location: ' . $enlace, true, 303);
        exit;
    }
}
