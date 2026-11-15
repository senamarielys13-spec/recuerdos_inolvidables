<?php
// controllers/ProveedorController.php
require_once __DIR__ . '/../models/Proveedor.php';

class ProveedorController {
    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new Proveedor();
    }

    private function verificarPermiso() {
        $rol = isset($_SESSION['user_rol']) ? (int)$_SESSION['user_rol'] : 0;
        $nombreRol = $_SESSION['user_rol_nombre'] ?? '';
        
        // Permitir acceso si es Administrador (1) o Proveedor (3)
        if ($rol !== 1 && $rol !== 3 && $nombreRol !== 'Administrador' && $nombreRol !== 'Proveedor') {
            header("Location: index.php?controller=proveedor&action=index");
            exit();
        }
    }

    public function index() {
        $proveedores = $this->modelo->obtenerTodos();
        require_once __DIR__ . '/../views/proveedores/index.php';
    }

    public function crear() {
        $this->verificarPermiso();
        require_once __DIR__ . '/../views/proveedores/crear.php';
    }

    public function guardar() {
        $this->verificarPermiso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            
            // Si es proveedor, asociamos automáticamente su ID de usuario de la sesión
            $rol = isset($_SESSION['user_rol']) ? (int)$_SESSION['user_rol'] : 0;
            if ($rol === 3) {
                $datos['id_usuario'] = $_SESSION['user_id'] ?? null;
            }

            // Capturamos el nombre ingresado y lo asignamos a todos los nombres posibles de columna
            $nombre_ingresado = trim($_POST['nombre_empresa'] ?? $_POST['nombre'] ?? $_POST['nombre_comercial'] ?? '');
            $datos['nombre'] = $nombre_ingresado;
            $datos['nombre_empresa'] = $nombre_ingresado;
            $datos['nombre_comercial'] = $nombre_ingresado;

            $this->modelo->registrar($datos);
            header("Location: index.php?controller=proveedor&action=index");
            exit();
        }
    }

    public function editar() {
        $this->verificarPermiso();
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $proveedor = $this->modelo->obtenerPorId($id);
            if ($proveedor) {
                require_once __DIR__ . '/../views/proveedores/editar.php';
            } else {
                header("Location: index.php?controller=proveedor&action=index");
                exit();
            }
        } else {
            header("Location: index.php?controller=proveedor&action=index");
            exit();
        }
    }

    public function actualizar() {
        $this->verificarPermiso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_proveedor'] ?? $_POST['id'] ?? null; 
            if ($id) {
                $datos = $_POST;
                $nombre_ingresado = trim($_POST['nombre_empresa'] ?? $_POST['nombre'] ?? $_POST['nombre_comercial'] ?? '');
                $datos['nombre'] = $nombre_ingresado;
                $datos['nombre_empresa'] = $nombre_ingresado;
                $datos['nombre_comercial'] = $nombre_ingresado;

                $this->modelo->actualizar($id, $datos);
            }
            header("Location: index.php?controller=proveedor&action=index");
            exit();
        }
    }

    public function eliminar() {
        $this->verificarPermiso();
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminar($id);
        }
        header("Location: index.php?controller=proveedor&action=index");
        exit();
    }
}
?>