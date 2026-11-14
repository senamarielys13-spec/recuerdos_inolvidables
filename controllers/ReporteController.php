

<?php

require_once __DIR__ . '/../config/Database.php';

class ReporteController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Solo administradores.
        if (
            empty($_SESSION['user_id']) ||
            (int) ($_SESSION['user_rol'] ?? 0) !== 1
        ) {
            http_response_code(403);
            exit('Acceso exclusivo para administradores.');
        }

        // Conexión a MariaDB.
        $database = new Database();
        $pdo = $database->getConnection();

        // Usuarios registrados.
        $totalUsuarios = (int) $pdo->query(
            'SELECT COUNT(*) FROM usuarios'
        )->fetchColumn();

        // Proveedores registrados.
        $totalProveedores = (int) $pdo->query(
            'SELECT COUNT(*) FROM proveedores'
        )->fetchColumn();

        // Servicios registrados.
        $totalServicios = (int) $pdo->query(
            'SELECT COUNT(*) FROM servicios'
        )->fetchColumn();

        // Total de contactos iniciados por WhatsApp.
        $totalContactos = (int) $pdo->query(
            'SELECT COUNT(*) FROM solicitudes_contacto'
        )->fetchColumn();

        // Contactos durante el mes actual.
        $contactosMes = (int) $pdo->query(
            "SELECT COUNT(*)
             FROM solicitudes_contacto
             WHERE fecha_envio >= DATE_FORMAT(
                 CURRENT_DATE(), '%Y-%m-01'
             )
             AND fecha_envio < DATE_FORMAT(
                 CURRENT_DATE() + INTERVAL 1 MONTH,
                 '%Y-%m-01'
             )"
        )->fetchColumn();

        // Cantidad de proveedores consultados.
        $proveedoresConsultados = (int) $pdo->query(
            'SELECT COUNT(DISTINCT id_proveedor)
             FROM solicitudes_contacto'
        )->fetchColumn();

        // Proveedores ordenados por contactos recibidos.
        $proveedoresMasConsultados = $pdo->query(
            'SELECT
                p.id_proveedor,
                p.nombre_comercial,
                COUNT(s.id_solicitud) AS total_contactos
             FROM proveedores p
             INNER JOIN solicitudes_contacto s
                ON s.id_proveedor = p.id_proveedor
             GROUP BY
                p.id_proveedor,
                p.nombre_comercial
             ORDER BY
                total_contactos DESC,
                p.nombre_comercial ASC'
        )->fetchAll(PDO::FETCH_ASSOC);

        // Proveedor con mayor número de contactos.
        $proveedorMasConsultado =
            $proveedoresMasConsultados[0] ?? null;

        // Contactos agrupados por mes.
        $contactosMensuales = $pdo->query(
            "SELECT
                DATE_FORMAT(
                    fecha_envio, '%Y-%m'
                ) AS periodo,
                COUNT(*) AS total_contactos
             FROM solicitudes_contacto
             GROUP BY
                DATE_FORMAT(fecha_envio, '%Y-%m')
             ORDER BY periodo ASC"
        )->fetchAll(PDO::FETCH_ASSOC);

        // Últimos 20 intentos de contacto.
        $ultimosContactos = $pdo->query(
            'SELECT
                s.id_solicitud,
                s.id_usuario,
                s.nombre_remitente,
                s.email_remitente,
                s.fecha_envio,
                p.nombre_comercial
             FROM solicitudes_contacto s
             INNER JOIN proveedores p
                ON p.id_proveedor = s.id_proveedor
             ORDER BY
                s.fecha_envio DESC,
                s.id_solicitud DESC
             LIMIT 20'
        )->fetchAll(PDO::FETCH_ASSOC);

        // Cargar la vista de reportes.
        require __DIR__ . '/../views/reportes/index.php';
    }
}
