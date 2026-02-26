<?php
require_once '../config/database.php';
require_once '../models/Venta.php';
require_once '../models/DetalleVenta.php';
require_once '../models/Producto.php';

class VentaController {

    public function store($productos) {

        $db = new Database();
        $conexion = $db->conectar();

        try {

            $conexion->beginTransaction();

            $ventaModel = new Venta($conexion);
            $detalleModel = new DetalleVenta($conexion);
            $productoModel = new Producto($conexion);

            $venta_id = $ventaModel->crear();

            $total = 0;

            foreach ($productos as $item) {

                $producto = $productoModel->obtenerPorId($item['producto_id']);

                if ($producto['stock'] < $item['cantidad']) {
                    throw new Exception("Stock insuficiente para " . $producto['nombre']);
                }

                $detalleModel->agregarProducto(
                    $venta_id,
                    $item['producto_id'],
                    $item['cantidad'],
                    $producto['precio']
                );

                $subtotal = $item['cantidad'] * $producto['precio'];
                $total += $subtotal;

                // descontar stock
                $sql = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    ':cantidad' => $item['cantidad'],
                    ':id' => $item['producto_id']
                ]);
            }

            $ventaModel->actualizarTotal($venta_id, $total);

            $conexion->commit();

            return true;

        } catch (Exception $e) {
            $conexion->rollBack();
            return $e->getMessage();
        }
    }
}
?>