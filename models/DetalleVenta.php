<?php

class DetalleVenta {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function agregarProducto($venta_id, $producto_id, $cantidad, $precio) {

        $subtotal = $cantidad * $precio;

        $sql = "INSERT INTO detalle_ventas
            (venta_id, producto_id, cantidad, precio_unitario, subtotal)
            VALUES (:venta_id, :producto_id, :cantidad, :precio, :subtotal)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':venta_id' => $venta_id,
            ':producto_id' => $producto_id,
            ':cantidad' => $cantidad,
            ':precio' => $precio,
            ':subtotal' => $subtotal
        ]);
    }
}
?>

