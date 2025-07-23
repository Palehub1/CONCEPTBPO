const API_URL = 'http://localhost/PRUEBA_TECNICA_CONCEPT_BPO/PUBLIC/index.php';

function crearProducto() {
    const form = document.querySelector('#form-producto');
    const editId = form.getAttribute('data-edit-id');


    const data = {
        nombre: document.querySelector('[name="nombre"]').value,
        descripcion: document.querySelector('[name="descripcion"]').value,
        rentabilidad: document.querySelector('[name="rentabilidad"]').value,
        riesgo: document.querySelector('[name="riesgo"]').value
    };


    if (editId){   data.id = editId;

    } else {
    }
    const method = editId ? 'PUT' : 'POST';

    fetch(API_URL, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(res => {
            alert(res.message);
            form.reset();
            form.removeAttribute('data-edit-id');
            document.querySelector('.form-button').textContent = 'Crear Producto';
            listarProductos();
        })
        .catch(err => console.error('Error al guardar producto:', err));
}

function eliminarProducto(id) {
    if (!confirm('¿Esta seguro de eliminar?')) return;

    fetch(API_URL, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
        .then(res => res.json())
        .then(res => {
            alert(res.message || 'Producto eliminado');
            listarProductos();
        })
        .catch(err => console.error('Error al eliminar producto:', err));
}

function toggleDescripcion(id) {
    const fila = document.getElementById(`descripcion-${id}`);
    fila.style.display = fila.style.display === 'table-row' ? 'none' : 'table-row';
}

function listarProductos() {
    fetch(API_URL)
        .then(response => response.json())
        .then(data => {
            const productosBody = document.getElementById('productos-body');
            productosBody.innerHTML = '';

            if (data.registros && data.registros.length > 0) {
                data.registros.forEach(producto => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${producto.nombre}</td>
                        <td>${producto.rentabilidad}</td>
                        <td>${producto.riesgo}</td>
                        <td>
                            <button onclick="toggleDescripcion(${producto.id})">Detalles</button>
                            <button onclick="eliminarProducto(${producto.id})">Borrar</button>
                            <button onclick="EditarProducto(${producto.id})">Actualizar</button>
                        </td>
                    `;

                    const filaDescripcion = document.createElement('tr');
                    filaDescripcion.id = `descripcion-${producto.id}`;
                    filaDescripcion.style.display = 'none';
                    filaDescripcion.innerHTML = `
                        <td colspan="4" style="background-color: #f1f1f1;">
                            <strong>Descripción:</strong> ${producto.descripcion}
                        </td>
                    `;

                    productosBody.appendChild(fila);
                    productosBody.appendChild(filaDescripcion);
                });
            } else {
                const fila = document.createElement('tr');
                fila.innerHTML = `<td colspan="4">No hay productos disponibles</td>`;
                productosBody.appendChild(fila);
            }
        })
        .catch(error => {
            console.error('Error al listar productos:', error);
        });
}

function EditarProducto(id) {
    fetch(`${API_URL}?id=${id}`)
        .then(res => res.json())
        .then(data => {

            const producto = data.registros?.[0] || data;

            if (producto && producto.id) {
                document.querySelector('[name="nombre"]').value = producto.nombre;
                document.querySelector('[name="descripcion"]').value = producto.descripcion;
                document.querySelector('[name="rentabilidad"]').value = producto.rentabilidad;
                document.querySelector('[name="riesgo"]').value = producto.riesgo;

                const form = document.getElementById('form-producto');
                form.setAttribute('data-edit-id', producto.id);

                document.querySelector('.form-button').textContent = 'Actualizar Producto';

              
            } else {
                alert('Producto no encontrado');
            }
        })
        .catch(err => console.error(' Error al editar producto:', err));
}

document.addEventListener('DOMContentLoaded', () => {
    listarProductos();

    const form = document.querySelector('#form-producto');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            crearProducto();
        });
    }
});
