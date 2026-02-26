<?php 
class Database {

    private $host = "localhost";
    private $db   = "inventario";
    private $user = "root";
    private $pass = "1234";
    private $charset = "utf8mb4";

    public function conectar() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

require_once '../config/database.php';

$db = new Database();
$conexion = $db->conectar();


?>
