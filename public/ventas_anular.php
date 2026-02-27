<?php
require_once '../controllers/VentaController.php';

if (!isset($_GET['id'])) {
    die("ID no especificado");
}

$controller = new VentaController();
$resultado = $controller->anular($_GET['id']);

if ($resultado === true) {
    header("Location: ventas_listar.php");
} else {
    echo "Error: " . $resultado;
}
?>

