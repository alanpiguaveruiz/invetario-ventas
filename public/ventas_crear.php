<?php
require_once '../controllers/VentaController.php';
require_once '../config/database.php';

$error = '';

/* ==============================
   ENDPOINT AJAX PARA BUSCAR PRODUCTO
============================== */
if (isset($_GET['action']) && $_GET['action'] == 'buscar') {

    $controller = new VentaController();
    $producto = $controller->buscarProducto($_GET['id']);

    header('Content-Type: application/json');
    echo json_encode($producto);
    exit;
}


/* ==============================
   PROCESAR REGISTRO DE VENTA
============================== */
if ($_POST) {

    $items = [];

    if (!empty($_POST['productos'])) {
        foreach ($_POST['productos'] as $prod) {
            if ($prod['cantidad'] > 0) {
                $items[] = [
                    'producto_id' => $prod['id'],
                    'cantidad' => $prod['cantidad']
                ];
            }
        }
    }

    if (empty($items)) {
        $error = "Debes agregar al menos un producto";
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

<label>ID Producto:</label>
<input type="number" id="producto_id">
<button type="button" onclick="agregarProducto()">Agregar</button>

<br><br>

<form method="post">
    <table border="1" id="tablaProductos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <br>
    <button type="submit">Registrar Venta</button>
</form>

<br>
<a href="ventas_listar.php">Ver Ventas</a>

<script src="js/ventas.js"></script>