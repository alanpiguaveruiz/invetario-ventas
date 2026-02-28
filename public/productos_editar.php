<?php
require_once '../controllers/ProductoController.php';
require_once '../models/Producto.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) die('ID no válido');

$db = new Database();
$modelo = new Producto($db->conectar());
$producto = $modelo->obtenerPorId($id);

$controller = new ProductoController();
$error = '';

if ($_POST) {
    $resultado = $controller->update($id, $_POST);
    if ($resultado === true) {
        header('Location: index.php?modulo=productos_listar');
        exit;
    } else {
        $error = $resultado;
    }
}
?>

<h2>Editar producto</h2>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>

<form method="post">
    Nombre: <input name="nombre" value="<?= $producto['nombre'] ?>"><br>
    Tipo:
    <select name="tipo">
        <?php
        $tipos = ['Fertilizante','Abono','Insecticida','Fungicida','Herbicida'];
        foreach ($tipos as $t) {
            $sel = ($producto['tipo'] == $t) ? 'selected' : '';
            echo "<option $sel>$t</option>";
        }
        ?>
    </select><br>
    Descripción: <textarea name="descripcion"><?= $producto['descripcion'] ?></textarea><br>
    Precio: <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>"><br>
    Stock: <input type="number" name="stock" value="<?= $producto['stock'] ?>"><br>
    Unidad: <input name="unidad" value="<?= $producto['unidad'] ?>"><br><br>
    <button type="submit">Actualizar</button>
</form>

<a href="index.php?modulo=productos_listar">Volver</a>