<?php
// controllers/EventoController.php
require_once __DIR__ . '/../models/Evento.php';

class EventoController {
    private $eventoModel;

    public function __construct() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $this->eventoModel = new Evento();
    }

    // Listar todos los eventos del usuario (Read)
    public function index() {
        $user_id = $_SESSION['user_id'];
        $eventos = $this->eventoModel->obtenerPorUsuario($user_id);

        require_once __DIR__ . '/../views/eventos/index.php';
    }

    // Crear un nuevo evento (Create)
    public function crear() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_evento = trim($_POST['nombre_evento'] ?? '');
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $presupuesto = !empty($_POST['presupuesto']) ? (float)$_POST['presupuesto'] : 0.00;
            $lugar = trim($_POST['lugar'] ?? '');
            $estado = $_POST['estado'] ?? 'Planificando';

            if (empty($nombre_evento) || empty($fecha_evento)) {
                $error = "El nombre y la fecha del evento son obligatorios.";
            } else {
                if ($this->eventoModel->crear($_SESSION['user_id'], $nombre_evento, $fecha_evento, $presupuesto, $lugar, $estado)) {
                    header("Location: index.php?controller=evento&action=index");
                    exit;
                } else {
                    $error = "Error al crear el evento. Inténtalo de nuevo.";
                }
            }
        }

        require_once __DIR__ . '/../views/eventos/crear.php';
    }

    // Editar un evento (Update)
    public function editar() {
        $id_evento = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user_id = $_SESSION['user_id'];

        $evento = $this->eventoModel->obtenerPorId($id_evento, $user_id);

        if (!$evento) {
            header("Location: index.php?controller=evento&action=index");
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_evento = trim($_POST['nombre_evento'] ?? '');
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $presupuesto = !empty($_POST['presupuesto']) ? (float)$_POST['presupuesto'] : 0.00;
            $lugar = trim($_POST['lugar'] ?? '');
            $estado = $_POST['estado'] ?? 'Planificando';

            if (empty($nombre_evento) || empty($fecha_evento)) {
                $error = "El nombre y la fecha del evento son obligatorios.";
            } else {
                if ($this->eventoModel->actualizar($id_evento, $user_id, $nombre_evento, $fecha_evento, $presupuesto, $lugar, $estado)) {
                    header("Location: index.php?controller=evento&action=index");
                    exit;
                } else {
                    $error = "Error al actualizar el evento.";
                }
            }
        }

        require_once __DIR__ . '/../views/eventos/editar.php';
    }

    // Eliminar evento (Delete)
    public function eliminar() {
        $id_evento = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user_id = $_SESSION['user_id'];

        if ($id_evento > 0) {
            $this->eventoModel->eliminar($id_evento, $user_id);
        }

        header("Location: index.php?controller=evento&action=index");
        exit;
    }
}