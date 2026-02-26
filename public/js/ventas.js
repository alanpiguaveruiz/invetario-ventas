let contador = 0;

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