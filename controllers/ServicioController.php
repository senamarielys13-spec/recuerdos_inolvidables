<?php
require_once __DIR__ . '/../models/Servicio.php';

class ServicioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Servicio();
    }

    public function index() {
        $servicios = $this->modelo->obtenerTodos();
        require_once __DIR__ . '/../views/servicios/index.php';
    }

    public function crear() {
        $categorias = $this->modelo->obtenerCategorias();
        require_once __DIR__ . '/../views/servicios/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                // Convierte cadenas vacías o 0 a NULL para evitar errores de llave foránea
                'id_proveedor' => (!empty($_POST['id_proveedor']) && $_POST['id_proveedor'] > 0) ? $_POST['id_proveedor'] : null,
                'id_categoria' => (!empty($_POST['id_categoria']) && $_POST['id_categoria'] > 0) ? $_POST['id_categoria'] : null,
                'nombre'       => $_POST['nombre'] ?? '',
                'descripcion'  => $_POST['descripcion'] ?? '',
                'precio'       => $_POST['precio'] ?? 0.00
            ];

            if (!empty($datos['nombre'])) {
                $this->modelo->crear($datos);
            }

            header("Location: index.php?controller=servicio&action=index");
            exit();
        }
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $servicio = $this->modelo->obtenerPorId($id);
            $categorias = $this->modelo->obtenerCategorias();
            require_once __DIR__ . '/../views/servicios/editar.php';
        } else {
            header("Location: index.php?controller=servicio&action=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_servicio'] ?? null;
            $datos = [
                'id_categoria' => (!empty($_POST['id_categoria']) && $_POST['id_categoria'] > 0) ? $_POST['id_categoria'] : null,
                'nombre'       => $_POST['nombre'] ?? '',
                'descripcion'  => $_POST['descripcion'] ?? '',
                'precio'       => $_POST['precio'] ?? 0.00
            ];

            if ($id && !empty($datos['nombre'])) {
                $this->modelo->actualizar($id, $datos);
            }
            header("Location: index.php?controller=servicio&action=index");
            exit();
        }
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminar($id);
        }
        header("Location: index.php?controller=servicio&action=index");
        exit();
    }
}
?>