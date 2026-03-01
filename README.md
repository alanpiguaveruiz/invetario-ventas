### Inventario y Sistema de Ventas Agrícola: AGROCHICHO

###  Descripción

Aplicación web desarrollada en **PHP (POO)** con arquitectura modular tipo MVC simplificado, orientada a la gestión de productos agrícolas e inventario, incluyendo el registro y anulación de ventas con control automático de stock.

El sistema permite:

* Gestión completa de productos (CRUD)
* Registro de ventas con múltiples productos
* Control automático de inventario
* Anulación de ventas con reversión de stock
* Panel de navegación modular

---

###  Tecnologías Utilizadas

* **PHP 8**
* **MySQL**
* **PDO (PHP Data Objects)**
* **HTML5**
* **CSS3**
* JavaScript (para dinámica en ventas)
* phpMyAdmin (para gestión de BD)

---

###  Arquitectura del Proyecto

El proyecto está organizado bajo una estructura modular con separación de responsabilidades:

```
/config
    database.php

/controllers
    ProductoController.php
    VentaController.php

/models
    Producto.php
    Venta.php
    DetalleVenta.php

/public
    index.php
    productos_listar.php
    productos_crear.php
    productos_editar.php
    productos_eliminar.php
    ventas_listar.php
    ventas_crear.php
    ventas_anular.php
    /css
        style.css
    /js
        ventas.js
```

###  Patrón aplicado

Se implementa una arquitectura tipo **MVC simplificado**:

* **Modelos** → Acceso a datos y consultas SQL
* **Controladores** → Lógica de negocio y validaciones
* **Vistas (módulos)** → Interfaz de usuario
* **index.php** → Router central por parámetro `?modulo=`

---

####  Base de Datos

Base de datos: `inventario`

###  Tablas principales

###  productos

* id
* nombre
* tipo (ENUM)
* descripcion
* precio
* stock
* unidad
* created_at

###  ventas

* id
* fecha
* total
* estado (Pendiente | Pagada | Anulada)

###  detalle_ventas

* id
* venta_id (FK)
* producto_id (FK)
* cantidad
* precio_unitario
* subtotal

###  Relaciones

* Una venta puede tener múltiples detalles
* Cada detalle pertenece a una venta
* Cada detalle referencia a un producto
* Uso de **Foreign Keys con ON DELETE CASCADE**

---

###  Funcionalidades

###  Módulo Productos

* Listar productos
* Crear producto
* Editar producto
* Eliminar producto
* Validaciones:

  * Nombre obligatorio
  * Precio > 0
  * Stock >= 0

---

###  Módulo Ventas

* Crear venta con múltiples productos
* Búsqueda dinámica de producto (AJAX)
* Cálculo automático de subtotal y total
* Descuento automático de stock
* Uso de **transacciones PDO**
* Anulación de venta:

  * Cambia estado a "Anulada"
  * Devuelve stock automáticamente
  * Protección contra doble anulación

---

###  Manejo de Transacciones

El módulo de ventas utiliza:

```php
$conexion->beginTransaction();
$conexion->commit();
$conexion->rollBack();
```

Esto garantiza:

* Integridad de datos
* Consistencia del inventario
* Reversión automática ante errores

---

###  Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/tuusuario/inventario.git
```

2. Importar la base de datos:

   * Abrir phpMyAdmin
   * Crear BD `inventario`
   * Importar el archivo `.sql`

3. Configurar credenciales en:

```
config/database.php
```

4. Ejecutar en navegador:

```
http://localhost/tu_proyecto/public/
```

---

###  Interfaz

* Dashboard principal
* Navegación por módulos
* Tablas estilizadas
* Formularios responsivos
* Confirmaciones antes de eliminar/anular

---

###  Buenas Prácticas Aplicadas

- Uso de PDO con prepared statements
- Manejo de excepciones
- Validaciones en controlador
- Separación de responsabilidades
- Uso de transacciones en procesos críticos
- Clases y programación orientada a objetos

---

###  Posibles Mejoras Futuras

* Sistema de autenticación de usuarios
* Reportes de ventas
* Filtros y búsquedas avanzadas
* Paginación
* Exportación a PDF / Excel
* Dashboard con estadísticas
* API REST
* Variables de entorno para credenciales

---

### Desarrollado como proyecto académico: Activdad Integradora 2

* Arquitectura MVC
* Programación orientada a objetos
* Manejo de inventario
* Transacciones en bases de datos

---

###  Nivel del Proyecto

Este proyecto demuestra:

* Dominio de CRUD completo
* Manejo correcto de relaciones en BD
* Lógica de negocio estructurada
* Control de integridad con transacciones
* Organización modular escalable




---

Ventana Inicial – Dashboard Principal

Archivo: index.php

### Descripción General

Es la pantalla principal del sistema y funciona como contenedor central de los módulos.
Desde esta vista el usuario puede navegar hacia:

Módulo de Productos

Módulo de Ventas

Actúa como controlador frontal básico mediante el parámetro modulo enviado por URL.

### Estructura Visual

La ventana se compone de tres secciones principales:

### Header

Título del sistema:
“Panel de Control - Inventario y Ventas”

Menú de navegación con botones:

Home

Productos

Ventas

### Main (Contenido Dinámico)

Aquí se cargan los módulos mediante:

switch ($modulo) {
    case 'productos_listar':
        include 'productos_listar.php';
        break;
    ...
}

Esto permite que el sistema funcione como una aplicación modular sin cambiar de archivo principal.

Si no se selecciona módulo, muestra:

Mensaje de bienvenida

Indicaciones para comenzar

### Footer

Pie de página con copyright:
© 2026 Inventario App

<img width="1410" height="675" alt="image" src="https://github.com/user-attachments/assets/97457723-09dc-4d2c-bcf9-23e9a988967e" />


# Vistas del Sistema

---

## 1 Formulario: Nuevo Producto

**Archivo:** `productos_crear.php`

### Descripción

Este formulario permite el registro de nuevos productos agrícolas dentro del sistema.
El usuario puede ingresar la información básica necesaria para almacenar el producto en la base de datos.

### Campos del formulario

* **Nombre:** Identificación del producto.
* **Tipo:** Selección desplegable (Fertilizante, Abono, Insecticida, Fungicida, Herbicida).
* **Descripción:** Información adicional del producto.
* **Precio:** Valor unitario (decimal).
* **Stock:** Cantidad disponible en inventario.
* **Unidad:** Unidad de medida (ej: kg, litros, unidades).

###  Funcionamiento

* El formulario utiliza método **POST**.
* Al enviarse, ejecuta el método `store()` del `ProductoController`.
* Si la operación es exitosa, redirige al listado de productos.
* Si existe error, muestra mensaje en color rojo.

<img width="1410" height="675" alt="image" src="https://github.com/user-attachments/assets/04551f80-cb88-4fac-9156-c4f6e141b423" />

### No permite stock negativo y lanza un mensaje de stock invalido
<img width="1763" height="844" alt="image" src="https://github.com/user-attachments/assets/17b7c9b5-bbbc-458a-a029-6839d9bbbd5b" />

---

## 2 Formulario: Editar Producto

**Archivo:** `productos_editar.php`

### Descripción

Permite modificar la información de un producto ya existente.

### Características técnicas

* Obtiene el ID mediante `$_GET`.
* Carga los datos actuales desde la base de datos.
* Los campos aparecen prellenados.
* Utiliza el método `update()` del `ProductoController`.

### Particularidad importante

El campo **Tipo** mantiene seleccionada automáticamente la opción guardada en la base de datos mediante lógica condicional.

<img width="1410" height="675" alt="image" src="https://github.com/user-attachments/assets/79734a0c-7f2e-4cba-819e-563a995cb3a2" />


---

## 3 Vista: Listado de Productos

 **Archivo:** `productos_listar.php`

### Descripción

Muestra todos los productos registrados en el sistema en formato tabla.

###  Columnas mostradas

* ID
* Nombre
* Tipo
* Precio
* Stock
* Acciones (Editar / Eliminar)

###  Funcionalidad

* La información se obtiene mediante el método `index()` del `ProductoController`.
* Cada fila incluye:

  * Botón **Editar**
  * Botón **Eliminar** con confirmación JavaScript.

<img width="1534" height="736" alt="image" src="https://github.com/user-attachments/assets/44326b39-f356-45b2-a771-4cdfbd594bfe" />
<img width="1534" height="741" alt="image" src="https://github.com/user-attachments/assets/f0e42d38-a19b-451a-a9fc-d5b16f980842" />
<img width="1410" height="675" alt="image" src="https://github.com/user-attachments/assets/bf78bae2-af69-45ac-b853-f95789110643" />

---

## 4 Formulario: Nueva Venta

 **Archivo:** `ventas_crear.php`

###  Descripción

Permite registrar una nueva venta agregando múltiples productos dinámicamente.

###  Características principales

* Campo para ingresar ID del producto.
* Botón “Agregar” que utiliza JavaScript.
* Consulta AJAX para buscar producto.
* Tabla dinámica donde se agregan productos.
* Campo editable de cantidad.

### Validaciones

* No permite registrar venta sin productos.
* No permite cantidad mayor al stock disponible.
* Procesa los datos mediante `VentaController->store()`.

<img width="1919" height="920" alt="image" src="https://github.com/user-attachments/assets/a4ff3ac9-b965-46e9-8d0d-3cc1af63f5e3" />


---

## 5 Vista: Listado de Ventas

 **Archivo:** `ventas_listar.php`

###  Descripción

Muestra todas las ventas registradas en el sistema.

### Columnas

* ID
* Fecha
* Total
* Estado (Activa / Anulada)
* Acción (Anular)

###  Funcionalidad

* Permite anular ventas.
* Si la venta ya está anulada, deshabilita la opción.
* Implementa confirmación antes de anular.


---

## 6 Proceso: Anulación de Venta

 **Archivo:** `ventas_anular.php`

###  Descripción

Permite cambiar el estado de una venta a “Anulada”.

###  Proceso técnico

* Recibe el ID por GET.
* Ejecuta método `anular()` del `VentaController`.
* Redirige nuevamente al listado.
* Muestra error si ocurre algún problema.

<img width="1919" height="928" alt="image" src="https://github.com/user-attachments/assets/d00d164d-b23a-41fa-8bb6-6b0470517b17" />



## Uso de IA

Declaro que utilicé Inteligencia Artificial como apoyo para comprender partes del proyecto. El código fue adaptado, modificado y entendido por mí.

Utilicé Inteligencia Artificial como apoyo para comprender el uso de localStorage y la manipulación dinámica del DOM en JavaScript.

El código fue adaptado, modificado y comentado por mí, integrándolo a mi propia lógica de programación
