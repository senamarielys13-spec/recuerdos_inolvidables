<?php
// controllers/CarritoController.php

class CarritoController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Muestra la vista del carrito
    public function index() {
        $carrito = $_SESSION['carrito'];
        require_once __DIR__ . '/../views/carrito/index.php';
    }

    // Agrega un servicio/proveedor al carrito
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? 'Servicio / Cotización';
            $precio = floatval($_POST['precio'] ?? 0);
            $cantidad = intval($_POST['cantidad'] ?? 1);

            if ($id) {
                if (isset($_SESSION['carrito'][$id])) {
                    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
                } else {
                    $_SESSION['carrito'][$id] = [
                        'id'       => $id,
                        'nombre'   => $nombre,
                        'precio'   => $precio,
                        'cantidad' => $cantidad
                    ];
                }
            }
        }
        header("Location: index.php?controller=carrito&action=index");
        exit();
    }

    // Elimina un ítem específico
    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header("Location: index.php?controller=carrito&action=index");
        exit();
    }

    // Vacía todo el carrito
    public function vaciar() {
        $_SESSION['carrito'] = [];
        header("Location: index.php?controller=carrito&action=index");
        exit();
    }
}
?>