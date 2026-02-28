<?php
require_once '../models/venta.php';
require_once '../config/database.php';

$db = new Database();
$conexion = $db->conectar();

$ventaModel = new Venta($conexion);
$ventas = $ventaModel->obtenerTodas();
?>

<!-- Botón Nueva Venta arriba -->



<h2>Listado de Ventas</h2>
<br>
<a href="index.php?modulo=ventas_crear">Nueva Venta</a>
<br><br>
<table border="1">
<tr>
    <th>ID</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

<?php foreach ($ventas as $v): ?>
<tr>
    <td><?= $v['id'] ?></td>
    <td><?= $v['fecha'] ?></td>
    <td>$<?= $v['total'] ?></td>
    <td><?= $v['estado'] ?></td>
    <td>
        <?php if ($v['estado'] !== 'Anulada'): ?>
            <a href="ventas_anular.php?id=<?= $v['id'] ?>"
               onclick="return confirm('¿Seguro que deseas anular esta venta?')">
               Anular
            </a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>