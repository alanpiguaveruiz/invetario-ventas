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


    public function buscarProducto($id) {
        $db = new Database();
        $conexion = $db->conectar();

        $producto = new Producto($conexion);
        return $producto->obtenerPorId($id);
    }
    
    
   
    public function anular($venta_id){

    $db = new Database();
    $conexion = $db->conectar();

    try {

        $conexion->beginTransaction();

        // 1. Verificar venta
        $stmt = $conexion->prepare("SELECT * FROM ventas WHERE id = ?");
        $stmt->execute([$venta_id]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            throw new Exception("Venta no encontrada");
        }

        if ($venta['estado'] === 'Anulada') {
            throw new Exception("La venta ya está anulada");
        }

        // 2. Obtener detalles
        $stmt = $conexion->prepare("SELECT * FROM detalle_ventas WHERE venta_id = ?");
        $stmt->execute([$venta_id]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 3. Devolver stock
        foreach ($detalles as $detalle) {

            $stmtUpdate = $conexion->prepare("
                UPDATE productos 
                SET stock = stock + ? 
                WHERE id = ?
            ");

            $stmtUpdate->execute([
                $detalle['cantidad'],
                $detalle['producto_id']
            ]);
        }

        // 4. Cambiar estado
        $stmt = $conexion->prepare("
            UPDATE ventas 
            SET estado = 'Anulada' 
            WHERE id = ?
        ");

        $stmt->execute([$venta_id]);

        $conexion->commit();
        return true;

    } catch (Exception $e) {
        $conexion->rollBack();
        return $e->getMessage();
    }
}
    
    
    
    
    
    
    
}
?>