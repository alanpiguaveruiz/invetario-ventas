<?php
require_once '../controllers/VentaController.php';
require_once '../models/producto.php';
require_once '../config/database.php';

$db = new Database();
$conexion = $db->conectar();

$productoModel = new Producto($conexion);
$productos = $productoModel->obtenerTodos();

$error = '';

if ($_POST) {

    $items = [];

    foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
        if ($cantidad > 0) {
            $items[] = [
                'producto_id' => $producto_id,
                'cantidad' => $cantidad
            ];
        }
    }

    if (empty($items)) {
        $error = "Debes seleccionar al menos un producto";
    } else {
        $controller = new VentaController();
        $resultado = $controller->store($items);

        if ($resultado === true) {
            header("Location: ventas_listar.php");
            exit;
        } else {
            $error = $resultado;
        }
    }
}
?>

<h2>Nueva Venta</h2>

<?php if ($error): ?>
<p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post">
<table border="1">
<tr>
    <th>Producto</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Cantidad</th>
</tr>

<?php foreach ($productos as $p): ?>
<tr>
    <td><?= $p['nombre'] ?></td>
    <td>$<?= $p['precio'] ?></td>
    <td><?= $p['stock'] ?></td>
    <td>
        <input 
            type="number" 
            name="cantidad[<?= $p['id'] ?>]" 
            min="0" 
            max="<?= $p['stock'] ?>" 
            value="0"
        >
    </td>
</tr>
<?php endforeach; ?>

</table>

<br>
<button type="submit">Registrar Venta</button>
</form>

<a href="ventas_listar.php">Ver Ventas</a>