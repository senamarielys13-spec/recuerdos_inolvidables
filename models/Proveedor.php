<?php
// models/Proveedor.php
require_once __DIR__ . '/../config/database.php';

class Proveedor {
    private $conn;
    private $table_name = "proveedores";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los proveedores con el nombre de su categoría
    public function obtenerTodos($categoria_id = null) {
        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM " . $this->table_name . " p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria";

        if ($categoria_id) {
            $sql .= " WHERE p.id_categoria = :categoria_id";
        }

        $sql .= " ORDER BY p.destacado DESC, p.nombre_comercial ASC";

        $stmt = $this->conn->prepare($sql);

        if ($categoria_id) {
            $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener categorías para el filtro
    public function obtenerCategorias() {
        $stmt = $this->conn->prepare("SELECT * FROM categorias ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}