
<?php
require_once __DIR__ . '/../config/Database.php';

class Nota
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

        if (!$this->db) {
            throw new RuntimeException(
                'No se pudo conectar a la base de datos.'
            );
        }
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        $sql = '
            SELECT
                n.id_nota,
                n.id_proveedor,
                n.observacion,
                n.fecha_creacion,
                n.fecha_actualizacion,
                p.nombre_comercial,
                p.descripcion,
                p.telefono,
                p.email,
                p.direccion
            FROM notas_servicios n
            INNER JOIN proveedores p
                ON p.id_proveedor = n.id_proveedor
            WHERE n.id_usuario = :usuario
            ORDER BY
                n.fecha_actualizacion DESC,
                n.id_nota DESC
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':usuario' => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar(
        int $usuarioId,
        int $proveedorId
    ): bool {

        $verificar = $this->db->prepare(
            'SELECT id_proveedor
             FROM proveedores
             WHERE id_proveedor = :id'
        );

        $verificar->execute([
            ':id' => $proveedorId
        ]);

        if (!$verificar->fetchColumn()) {
            return false;
        }

        $sql = '
            INSERT INTO notas_servicios
                (id_usuario, id_proveedor)
            VALUES
                (:usuario, :proveedor)
            ON DUPLICATE KEY UPDATE
                fecha_actualizacion = CURRENT_TIMESTAMP
        ';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario' => $usuarioId,
            ':proveedor' => $proveedorId
        ]);
    }

    public function guardarObservacion(
        int $usuarioId,
        int $notaId,
        string $observacion
    ): bool {

        $stmt = $this->db->prepare(
            'UPDATE notas_servicios
             SET observacion = :observacion
             WHERE id_nota = :nota
               AND id_usuario = :usuario'
        );

        $stmt->execute([
            ':observacion' => $observacion,
            ':nota' => $notaId,
            ':usuario' => $usuarioId
        ]);

        return $stmt->rowCount() > 0;
    }

    public function eliminar(
        int $usuarioId,
        int $notaId
    ): bool {

        $stmt = $this->db->prepare(
            'DELETE FROM notas_servicios
             WHERE id_nota = :nota
               AND id_usuario = :usuario'
        );

        return $stmt->execute([
            ':nota' => $notaId,
            ':usuario' => $usuarioId
        ]);
    }
}
