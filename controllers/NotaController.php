
<?php
require_once __DIR__ . '/../models/Nota.php';

class NotaController
{
    private $modelo;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->modelo = new Nota();
    }

    // Permitir acceso a los tres tipos de usuarios.
    private function exigirUsuario(): int
    {
        if (empty($_SESSION['user_id'])) {
            header(
                'Location: index.php?controller=auth&action=login'
            );
            exit;
        }

        $rol = (int) ($_SESSION['user_rol'] ?? 0);

        if (!in_array($rol, [1, 2, 3], true)) {
            http_response_code(403);
            exit('No tienes permiso para acceder a Mis notas.');
        }

        return (int) $_SESSION['user_id'];
    }

    // Validar solicitudes del formulario.
    private function comprobarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido.');
        }

        $token = (string) ($_POST['csrf'] ?? '');
        $tokenSesion = (string) (
            $_SESSION['notas_csrf'] ?? ''
        );

        if (
            $token === '' ||
            $tokenSesion === '' ||
            !hash_equals($tokenSesion, $token)
        ) {
            http_response_code(403);
            exit(
                'Formulario no válido. '
                . 'Recarga la página e inténtalo nuevamente.'
            );
        }
    }

    // Mostrar las notas del usuario conectado.
    public function index(): void
    {
        $usuarioId = $this->exigirUsuario();

        if (empty($_SESSION['notas_csrf'])) {
            $_SESSION['notas_csrf'] = bin2hex(
                random_bytes(32)
            );
        }

        $notas = $this->modelo->obtenerPorUsuario(
            $usuarioId
        );

        require __DIR__ . '/../views/notas/index.php';
    }

    // Guardar un proveedor en Mis notas.
    public function agregar(): void
    {
        $usuarioId = $this->exigirUsuario();

        $this->comprobarFormulario();

        $proveedorId = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            !$proveedorId ||
            $proveedorId < 1 ||
            !$this->modelo->agregar(
                $usuarioId,
                $proveedorId
            )
        ) {
            http_response_code(400);
            exit('No se pudo guardar el proveedor.');
        }

        header(
            'Location: index.php?controller=nota&action=index'
        );
        exit;
    }

    // Guardar observaciones personales.
    public function guardar(): void
    {
        $usuarioId = $this->exigirUsuario();

        $this->comprobarFormulario();

        $notaId = filter_var(
            $_POST['id_nota'] ?? null,
            FILTER_VALIDATE_INT
        );

        $observacion = trim(
            (string) ($_POST['observacion'] ?? '')
        );

        if (
            !$notaId ||
            mb_strlen($observacion, 'UTF-8') > 2000
        ) {
            http_response_code(400);
            exit('La nota debe tener máximo 2000 caracteres.');
        }

        $this->modelo->guardarObservacion(
            $usuarioId,
            (int) $notaId,
            $observacion
        );

        header(
            'Location: index.php?controller=nota&action=index'
        );
        exit;
    }

    // Eliminar únicamente notas del usuario.
    public function eliminar(): void
    {
        $usuarioId = $this->exigirUsuario();

        $this->comprobarFormulario();

        $notaId = filter_var(
            $_POST['id_nota'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$notaId || $notaId < 1) {
            http_response_code(400);
            exit('Nota no válida.');
        }

        $this->modelo->eliminar(
            $usuarioId,
            (int) $notaId
        );

        header(
            'Location: index.php?controller=nota&action=index'
        );
        exit;
    }
}
