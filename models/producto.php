<?php
require_once '../config/database.php';

class Producto {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
     public function crear($data) {
        $sql = "INSERT INTO productos
        (nombre, tipo, descripcion, precio, stock, unidad)
        VALUES (:nombre, :tipo, :descripcion, :precio, :stock, :unidad)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':tipo' => $data['tipo'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':precio' => $data['precio'],
            ':stock' => $data['stock'],
            ':unidad' => $data['unidad'] ?? null
        ]);
    }
    
    public function actualizar($id, $data) {
    $sql = "UPDATE productos SET
        nombre = :nombre,
        tipo = :tipo,
        descripcion = :descripcion,
        precio = :precio,
        stock = :stock,
        unidad = :unidad
    WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ':nombre' => $data['nombre'],
        ':tipo' => $data['tipo'],
        ':descripcion' => $data['descripcion'] ?? null,
        ':precio' => $data['precio'],
        ':stock' => $data['stock'],
        ':unidad' => $data['unidad'] ?? null,
        ':id' => $id
    ]);
}
    
    public function obtenerPorId($id) {
    $sql = "SELECT * FROM productos WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function eliminar($id) {
    $sql = "DELETE FROM productos WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([':id' => $id]);
    }
    
}
?>