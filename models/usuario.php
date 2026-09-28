<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método requerido para el inicio de sesión (AuthController)
    public function obtenerPorEmail($email) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Listar todos los usuarios
    public function obtenerTodos() {
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por su ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Comprobar si un correo ya está registrado
    public function emailExiste($email) {
        $sql = "SELECT id_usuario FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ? true : false;
    }

    // Registrar usuario desde AuthController
    public function registrar($nombre, $email, $password, $id_rol = 2) {
        $sql = "INSERT INTO " . $this->table_name . " (nombre, email, password, id_rol, created_at) 
                VALUES (:nombre, :email, :password, :id_rol, NOW())";
        $stmt = $this->conn->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $passwordHash,
            ':id_rol'   => $id_rol
        ]);
    }

    // Crear usuario desde el panel de administración
    public function crear($datos) {
        $sql = "INSERT INTO " . $this->table_name . " (nombre, email, password, id_rol, created_at) 
                VALUES (:nombre, :email, :password, :id_rol, NOW())";
        $stmt = $this->conn->prepare($sql);
        $passwordHash = password_hash($datos['password'] ?? '123456', PASSWORD_DEFAULT);

        return $stmt->execute([
            ':nombre'   => $datos['nombre'],
            ':email'    => $datos['email'],
            ':password' => $passwordHash,
            ':id_rol'   => $datos['id_rol'] ?? 2
        ]);
    }

    // Actualizar usuario
    public function actualizar($id, $datos) {
        $sql = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, id_rol = :id_rol WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id'     => $id,
            ':nombre' => $datos['nombre'],
            ':email'  => $datos['email'],
            ':id_rol' => $datos['id_rol'] ?? 2
        ]);
    }

    // Eliminar usuario
    public function eliminar($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>