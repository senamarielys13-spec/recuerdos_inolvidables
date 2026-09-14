<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    
    // Mostrar y procesar Registro
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $telefono = trim($_POST['telefono'] ?? '');
            $id_rol = isset($_POST['id_rol']) ? (int)$_POST['id_rol'] : 2; // Default 2 (Cliente)

            if (empty($nombre) || empty($email) || empty($password)) {
                $error = "Por favor completa todos los campos obligatorios.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "El formato de correo electrónico no es válido.";
            } else {
                $usuarioModel = new Usuario();

                if ($usuarioModel->emailExiste($email)) {
                    $error = "El correo electrónico ya está registrado.";
                } else {
                    if ($usuarioModel->registrar($nombre, $email, $password, $telefono, $id_rol)) {
                        $success = "¡Registro exitoso! Ya puedes iniciar sesión.";
                    } else {
                        $error = "Ocurrió un error al registrar la cuenta. Inténtalo de nuevo.";
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
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