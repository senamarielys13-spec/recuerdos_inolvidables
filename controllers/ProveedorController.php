<?php
// controllers/ProveedorController.php
require_once __DIR__ . '/../models/Proveedor.php';

class ProveedorController {
    
    public function index() {
        $proveedorModel = new Proveedor();

        // Verificar si hay filtro por categoría
        $categoria_id = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;

        $proveedores = $proveedorModel->obtenerTodos($categoria_id);
        $categorias = $proveedorModel->obtenerCategorias();

        // Cargar vista
        require_once __DIR__ . '/../views/proveedores/index.php';
    }
}