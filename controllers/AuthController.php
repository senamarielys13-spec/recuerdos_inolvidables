<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    
    // Mostrar y procesar Registro
    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre   = $_POST['nombre'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();

        if ($usuarioModel->emailExiste($email)) {
            $error = "El correo ya se encuentra registrado.";
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

        if ($usuarioModel->registrar($nombre, $email, $password)) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        } else {
            $error = "Ocurrió un error al crear la cuenta.";
            require_once __DIR__ . '/../views/auth/register.php';
        }
    } else {
        require_once __DIR__ . '/../views/auth/register.php';
    }
}

    // Mostrar y procesar Login
    public function login() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Ingresa tu correo y contraseña.";
            } else {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->obtenerPorEmail($email);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    // Guardar datos clave en la sesión
                    $_SESSION['user_id'] = $usuario['id_usuario'];
                    $_SESSION['user_nombre'] = $usuario['nombre'];
                    $_SESSION['user_rol'] = $usuario['id_rol'];
                    $_SESSION['user_rol_nombre'] = $usuario['rol_nombre'];

                    // Redirigir al inicio o directorio
                    header("Location: index.php?controller=proveedor&action=index");
                    exit;
                } else {
                    $error = "Correo o contraseña incorrectos.";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Cerrar Sesión
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}