<?php
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Categoria();
    }

    // Muestra la pantalla principal con la lista
    public function index() {
        $categorias = $this->modelo->obtenerTodas();
        require_once __DIR__ . '/../views/categorias/index.php';
    }

    // Muestra el formulario para crear
    public function crear() {
        require_once __DIR__ . '/../views/categorias/crear.php';
    }

    // Recibe los datos del formulario y los guarda
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            
            if(!empty($nombre)) {
                $this->modelo->crear($nombre);
            }
            
            // Te devuelve a la lista de categorías
            header("Location: index.php?controller=categoria&action=index");
            exit();
        }
    }
    // Muestra el formulario para editar
    public function editar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $categoria = $this->modelo->obtenerPorId($id);
            require_once __DIR__ . '/../views/categorias/editar.php';
        } else {
            header("Location: index.php?controller=categoria&action=index");
        }
    }

    // Guarda los cambios de la edición
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_categoria'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            
            if ($id && !empty($nombre)) {
                $this->modelo->actualizar($id, $nombre);
            }
            header("Location: index.php?controller=categoria&action=index");
            exit();
        }
    }

    // Elimina la categoría
    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminar($id);
        }
        header("Location: index.php?controller=categoria&action=index");
        exit();
    }
}
?>