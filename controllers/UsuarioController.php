<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Usuario();
    }

    public function index() {
        $usuarios = $this->modelo->obtenerTodos();
        require_once __DIR__ . '/../views/usuarios/index.php';
    }

    public function crear() {
        require_once __DIR__ . '/../views/usuarios/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'password' => $_POST['password'] ?? '123456'
            ];

            if (!empty($datos['nombre']) && !empty($datos['email'])) {
                $this->modelo->crear($datos);
            }

            header("Location: index.php?controller=usuario&action=index");
            exit();
        }
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $usuario = $this->modelo->obtenerPorId($id);
            require_once __DIR__ . '/../views/usuarios/editar.php';
        } else {
            header("Location: index.php?controller=usuario&action=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_usuario'] ?? null;
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telefono' => $_POST['telefono'] ?? ''
            ];

            if ($id && !empty($datos['nombre'])) {
                $this->modelo->actualizar($id, $datos);
            }
            header("Location: index.php?controller=usuario&action=index");
            exit();
        }
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminar($id);
        }
        header("Location: index.php?controller=usuario&action=index");
        exit();
    }
}
?>