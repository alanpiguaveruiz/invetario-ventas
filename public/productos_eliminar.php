<?php
require_once '../controllers/ProductoController.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $controller = new ProductoController();
    $controller->delete($id);
}

header('Location: productos_listar.php');
exit;
?>