<?php
// models/Usuario.php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Registrar nuevo usuario con hash de contraseña seguro
    public function registrar($nombre, $email, $password, $telefono, $id_rol = 2) {
        $sql = "INSERT INTO " . $this->table_name . " (nombre, email, password, telefono, id_rol) 
                VALUES (:nombre, :email, :password, :telefono, :id_rol)";
        
        $stmt = $this->conn->prepare($sql);

        // Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':telefono', $telefono);
        $stmt->bindValue(':id_rol', $id_rol, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Buscar usuario por correo electrónico
    public function obtenerPorEmail($email) {
        $sql = "SELECT u.*, r.nombre AS rol_nombre 
                FROM " . $this->table_name . " u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Comprobar si un correo ya existe
    public function emailExiste($email) {
        $sql = "SELECT id_usuario FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}