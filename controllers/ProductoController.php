<?php
require_once '../config/database.php';
require_once '../models/Producto.php';

class ProductoController {

    public function index() {
        $db = new Database();
        $conexion = $db->conectar();

        $producto = new Producto($conexion);
        return $producto->obtenerTodos();
    }
    public function store($data) {
        if (empty($data['nombre'])) return "Nombre obligatorio";
        if ($data['precio'] <= 0) return "Precio inválido";
        if ($data['stock'] < 0) return "Stock inválido";

        $db = new Database();
        $conexion = $db->conectar();

        $producto = new Producto($conexion);
        return $producto->crear($data);
    }
    
    public function delete($id) {
    $db = new Database();
    $conexion = $db->conectar();

    $producto = new Producto($conexion);
    return $producto->eliminar($id);
    }
    
    public function update($id, $data) {
    if (empty($data['nombre'])) return "Nombre obligatorio";
    if ($data['precio'] <= 0) return "Precio inválido";
    if ($data['stock'] < 0) return "Stock inválido";

    $db = new Database();
    $conexion = $db->conectar();

    $producto = new Producto($conexion);
    return $producto->actualizar($id, $data);
    }
}
?>