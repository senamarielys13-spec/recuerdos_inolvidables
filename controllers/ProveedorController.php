<?php
require_once __DIR__ . '/../models/Proveedor.php';
require_once __DIR__ . '/../config/database.php';

class ProveedorController {
    private $model;
    private $db;

    public function __construct() {
        $this->model = new Proveedor();
        $this->db = (new Database())->getConnection();
    }

    public function index() {
        $proveedores = $this->model->obtenerTodos();
        
        // Cargar categorías dinámicas para los botones de filtro
        $stmtCat = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        $categorias = $stmtCat->fetchAll();

        require_once __DIR__ . '/../views/proveedores/index.php';
    }

    public function crear() {
        $stmtCat = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        $categorias = $stmtCat->fetchAll();

        require_once __DIR__ . '/../views/proveedores/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->crear($_POST);
            header('Location: index.php?controller=proveedor&action=index');
            exit();
        }
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $proveedor = $this->model->obtenerPorId($id);
            $stmtCat = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
            $categorias = $stmtCat->fetchAll();

            require_once __DIR__ . '/../views/proveedores/editar.php';
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_proveedor'];
            $this->model->actualizar($id, $_POST);
            header('Location: index.php?controller=proveedor&action=index');
            exit();
        }
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->eliminar($id);
        }
        header('Location: index.php?controller=proveedor&action=index');
        exit();
    }
}
?>