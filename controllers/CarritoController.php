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

    // Cargar la vista principal del carrito
    public function index() {
        require_once __DIR__ . '/../views/carrito/index.php';
    }

    // Agregar un ítem al carrito
    public function agregar() {
        $id = $_GET['id'] ?? null;
        $nombre = $_POST['nombre'] ?? $_GET['nombre'] ?? 'Servicio de Evento';
        $precio = $_POST['precio'] ?? $_GET['precio'] ?? 0;

        if ($id) {
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]['cantidad'] += 1;
            } else {
                $_SESSION['carrito'][$id] = [
                    'nombre'   => $nombre,
                    'precio'   => (float)$precio,
                    'cantidad' => 1
                ];
            }
        }

        header('Location: index.php?controller=carrito&action=index');
        exit();
    }

    // Eliminar un elemento específico
    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: index.php?controller=carrito&action=index');
        exit();
    }

    // Vaciar todo el carrito
    public function vaciar() {
        $_SESSION['carrito'] = [];
        header('Location: index.php?controller=carrito&action=index');
        exit();
    }
}