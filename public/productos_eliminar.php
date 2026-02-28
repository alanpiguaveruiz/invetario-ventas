<?php
require_once '../controllers/ProductoController.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $controller = new ProductoController();
    $controller->delete($id);
}

header('Location: index.php?modulo=productos_listar');
exit;
?>