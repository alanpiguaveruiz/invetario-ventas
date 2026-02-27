/*let contador = 0;

function agregarProducto() {

    let id = document.getElementById('producto_id').value;

    if (!id) {
        alert("Ingresa un ID");
        return;
    }

    fetch(`ventas_crear.php?action=buscar&id=${id}`)
        .then(res => res.json())
        .then(data => {

            if (!data) {
                alert("Producto no encontrado");
                return;
            }

            let tabla = document.querySelector("#tablaProductos tbody");

            tabla.innerHTML += `
                <tr>
                    <td>${data.id}
                        <input type="hidden" name="productos[${contador}][id]" value="${data.id}">
                    </td>
                    <td>${data.nombre}</td>
                    <td>${data.precio}</td>
                    <td>
                        <input type="number"
                               name="productos[${contador}][cantidad]"
                               value="1"
                               min="1">
                    </td>
                </tr>
            `;

            contador++;
            document.getElementById('producto_id').value = '';
        })
        .catch(() => {
            alert("Error al buscar el producto");
        });
    
}

function agregarProducto() {
    let id = document.getElementById("producto_id").value;
    if (!id) return alert("Ingresa un ID de producto");

    fetch(`ventas_crear.php?action=buscar&id=${id}`)
        .then(res => res.json())
        .then(producto => {
            if (!producto) {
                alert("Producto no encontrado");
                return;
            }

            // Crear fila simple con stock
            let fila = `
                <tr data-id="${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>$${producto.precio}</td>
                    <td>${producto.stock}</td>
                </tr>
            `;
            document.querySelector("#tablaProductos tbody").innerHTML += fila;
        })
        .catch(err => console.error(err));
}*/






let contador = 0;

function agregarProducto() {
    let id = document.getElementById('producto_id').value;
    if (!id) {
        alert("Ingresa un ID de producto");
        return;
    }

    fetch(`ventas_crear.php?action=buscar&id=${id}`)
        .then(res => res.json())
        .then(producto => {

            if (!producto) {
                alert("Producto no encontrado");
                return;
            }

            // Verificar si ya fue agregado
            if (document.querySelector(`#tablaProductos tbody tr[data-id="${producto.id}"]`)) {
                alert("El producto ya está agregado");
                return;
            }

            let tabla = document.querySelector("#tablaProductos tbody");

            // Crear fila con stock y cantidad
            tabla.innerHTML += `
                <tr data-id="${producto.id}">
                    <td>
                        ${producto.id}
                        <input type="hidden" name="productos[${contador}][id]" value="${producto.id}">
                    </td>
                    <td>${producto.nombre}</td>
                    <td>$${producto.precio}</td>
                    <td>${producto.stock}</td>
                    <td>
                        <input type="number"
                               name="productos[${contador}][cantidad]"
                               value="1"
                               min="1"
                               max="${producto.stock}">
                    </td>
                </tr>
            `;

            contador++;
            document.getElementById('producto_id').value = '';
        })
        .catch(() => {
            alert("Error al buscar el producto");
        });
}









