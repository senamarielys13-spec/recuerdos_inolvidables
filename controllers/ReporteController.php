<?php
// controllers/ReporteController.php

class ReporteController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar que el usuario tenga rol de Administrador
        if (!isset($_SESSION['user_rol']) || ($_SESSION['user_rol'] != 1 && $_SESSION['user_rol_nombre'] !== 'Administrador')) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        // Cargar la vista de reportes
        require_once __DIR__ . '/../views/reportes/index.php';
    }
}