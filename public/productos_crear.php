<?php
require_once '../controllers/ProductoController.php';
$controller = new ProductoController();
$error = '';

if ($_POST) {
    $resultado = $controller->store($_POST);
    if ($resultado === true) {
        header('Location: index.php?modulo=productos_listar');
        exit;
    } else {
        $error = $resultado;
    }
}
?>

<h2>Nuevo producto</h2>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>

<form method="post">
    Nombre: <input name="nombre"><br>
    Tipo:
    <select name="tipo">
        <option>Fertilizante</option>
        <option>Abono</option>
        <option>Insecticida</option>
        <option>Fungicida</option>
        <option>Herbicida</option>
    </select><br>
    Descripción: <textarea name="descripcion"></textarea><br>
    Precio: <input type="number" step="0.01" name="precio"><br>
    Stock: <input type="number" name="stock"><br>
    Unidad: <input name="unidad"><br><br>
    <button type="submit">Guardar</button>
</form>

<a href="index.php?modulo=productos_listar">Volver</a>