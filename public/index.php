<?php
// index.php - Dashboard principal que contiene los módulos
$modulo = $_GET['modulo'] ?? 'home'; // si no hay módulo, mostrar home
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $modulo === 'home' ? 'body-home' : '' ?>">
    <header>
        <h1>Panel de Control - Inventario y Ventas</h1>
        <nav>
            <a href="index.php?modulo=home" class="btn">Home</a>
            <a href="index.php?modulo=productos_listar" class="btn">Productos</a>
            <a href="index.php?modulo=ventas_listar" class="btn">Ventas</a>
        </nav>
    </header>

    <main>
        <?php
        // Cargar el módulo correspondiente
        switch ($modulo) {
            case 'productos_listar':
                include 'productos_listar.php';
                break;
            case 'productos_crear':
                include 'productos_crear.php';
                break;
            case 'productos_editar':
                include 'productos_editar.php';
                break;
            case 'productos_eliminar':
                include 'productos_eliminar.php';
                break;
            case 'ventas_listar':
                include 'ventas_listar.php';
                break;
            case 'ventas_crear':
                include 'ventas_crear.php';
                break;
            case 'ventas_anular':
                include 'ventas_anular.php';
                break;
            default:
                echo '<h2>Bienvenido al Dashboard</h2>
                      <p>Selecciona un módulo para comenzar</p>';
        
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2026 Inventario App</p>
    </footer>

    <script src="js/ventas.js"></script>
</body>
</html>