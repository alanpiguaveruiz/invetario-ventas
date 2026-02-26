<?php
require_once '../controllers/ProductoController.php';
$controller = new ProductoController();
$productos = $controller->index();
?>

<h2>Productos agrícolas</h2>
<a href="productos_crear.php">Nuevo producto</a>

<table border="1">
<tr>
    <th>ID</th><th>Nombre</th><th>Tipo</th><th>Precio</th><th>Stock</th><th>Acciones</th>
</tr>
<?php foreach ($productos as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['nombre'] ?></td>
    <td><?= $p['tipo'] ?></td>
    <td><?= $p['precio'] ?></td>
    <td><?= $p['stock'] ?></td>
    <td>
        <a href="productos_editar.php?id=<?= $p['id'] ?>">Editar</a>
        <a href="productos_eliminar.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
    </td>
</tr>
<?php endforeach; ?>

</table>