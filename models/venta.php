<?php

class Venta {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function crear() {
        $sql = "INSERT INTO ventas (total, estado) VALUES (0, 'Pendiente')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function actualizarTotal($id, $total) {
        $sql = "UPDATE ventas SET total = :total, estado = 'Pagada' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':total' => $total,
            ':id' => $id
        ]);
    }

    public function obtenerTodas() {
        $sql = "SELECT * FROM ventas ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>