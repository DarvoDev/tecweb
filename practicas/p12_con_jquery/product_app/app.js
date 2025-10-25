// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// Variable global para controlar el modo de edición
let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
}

$(document).ready(function() {
    console.log('jQuery cargado correctamente');
    
    // Inicializar el formulario con el JSON base
    init();
    
    // Cargar todos los productos al iniciar
    listarProductos();
    
    // EVENTO: Búsqueda en tiempo real mientras se escribe
    $('#search').keyup(function() {
        let search = $(this).val();
        
        if (search.trim() !== '') {
            buscarProducto(search);
        } else {
            listarProductos();
            $('#product-result').addClass('d-none');
        }
    });
    
    // EVENTO: Prevenir el envío del formulario de búsqueda
    $('.form-inline').submit(function(e) {
        e.preventDefault();
    });
    
    // EVENTO: Agregar o editar producto
    $('#product-form').submit(function(e) {
        e.preventDefault();
        agregarProducto();
    });
    
    // EVENTO: Eliminar producto (delegado para elementos dinámicos)
    $(document).on('click', '.product-delete', function() {
        let productId = $(this).closest('tr').attr('productId');
        eliminarProducto(productId);
    });
    
    // EVENTO: Cargar producto para editar (delegado para elementos dinámicos)
    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
        const element = $(this).closest('tr');
        const id = $(element).attr('productId');
        obtenerProducto(id);
    });
});

// FUNCIÓN PARA LISTAR TODOS LOS PRODUCTOS
function listarProductos() {
    console.log('Llamando a listarProductos()...');
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta recibida:', response);
            let productos = response;
            
            if (Object.keys(productos).length > 0) {
                let template = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>
                                <a href="#" class="product-item">
                                    ${producto.nombre}
                                </a>
                            </td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
                console.log('Productos listados correctamente');
            } else {
                console.log('No hay productos para mostrar');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al listar productos:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            alert('Error al cargar productos. Revisa la consola del navegador (F12).');
        }
    });
}

// FUNCIÓN PARA BUSCAR PRODUCTOS
function buscarProducto(search) {
    console.log('Buscando:', search);
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        dataType: 'json',
        success: function(response) {
            console.log('Resultados de búsqueda:', response);
            let productos = response;
            
            if (Object.keys(productos).length > 0) {
                let template = '';
                let template_bar = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>
                                <a href="#" class="product-item">
                                    ${producto.nombre}
                                </a>
                            </td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    template_bar += `<li>${producto.nombre}</li>`;
                });
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                $('#products').html(template);
            } else {
                $('#products').html('<tr><td colspan="4" class="text-center">No se encontraron productos</td></tr>');
                $('#product-result').addClass('d-none');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en búsqueda:', error);
            console.error('Response:', xhr.responseText);
        }
    });
}

// FUNCIÓN PARA OBTENER UN PRODUCTO POR ID (PARA EDITAR)
function obtenerProducto(id) {
    console.log('Obteniendo producto ID:', id);
    $.ajax({
        url: './backend/product-single.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            console.log('Producto obtenido:', response);
            
            // Llenar el formulario con los datos del producto
            $('#name').val(response.nombre);
            $('#productId').val(response.id);
            
            // Crear el JSON sin el nombre e id
            let productoJSON = {
                "precio": parseFloat(response.precio),
                "unidades": parseInt(response.unidades),
                "modelo": response.modelo,
                "marca": response.marca,
                "detalles": response.detalles,
                "imagen": response.imagen
            };
            
            $('#description').val(JSON.stringify(productoJSON, null, 2));
            
            // Cambiar el texto del botón
            $('#product-form button[type="submit"]').text('Actualizar Producto');
            
            // Activar modo edición
            edit = true;
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener producto:', error);
            console.error('Response:', xhr.responseText);
            alert('Error al cargar producto para editar.');
        }
    });
}

// FUNCIÓN PARA AGREGAR O EDITAR PRODUCTO
function agregarProducto() {
    let productoJsonString = $('#description').val();
    let finalJSON;
    
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch(error) {
        alert('Error: El JSON no es válido');
        return;
    }
    
    let nombre = $('#name').val().trim();
    
    // Validaciones
    if (!nombre || nombre.length > 100) {
        alert('El nombre es requerido y debe tener 100 caracteres o menos.');
        return;
    }
    
    if (!finalJSON.marca || finalJSON.marca === 'NA' || finalJSON.marca.trim() === '') {
        alert('La marca es requerida.');
        return;
    }
    
    let alfanumerico = /^[a-zA-Z0-9 ]+$/;
    if (!finalJSON.modelo || finalJSON.modelo.length > 25) {
        alert('El modelo es requerido y debe tener 25 caracteres o menos.');
        return;
    }
    if (!alfanumerico.test(finalJSON.modelo)) {
        alert('El modelo debe ser alfanumérico (letras, números y espacios).');
        return;
    }
    
    let precio = parseFloat(finalJSON.precio);
    if (isNaN(precio) || precio <= 99.99) {
        alert('El precio debe ser mayor a 99.99');
        return;
    }
    
    if (finalJSON.detalles && finalJSON.detalles !== 'NA' && finalJSON.detalles.length > 250) {
        alert('Los detalles deben tener 250 caracteres o menos.');
        return;
    }
    
    let unidades = parseInt(finalJSON.unidades);
    if (isNaN(unidades) || unidades < 0) {
        alert('Las unidades son requeridas y deben ser mayor o igual a 0.');
        return;
    }
    
    if (!finalJSON.imagen || finalJSON.imagen.trim() === '') {
        finalJSON.imagen = 'img/default.png';
    }
    
    finalJSON['nombre'] = nombre;
    
    // Si estamos en modo edición, agregar el ID
    if (edit) {
        finalJSON['id'] = $('#productId').val();
    }
    
    productoJsonString = JSON.stringify(finalJSON, null, 2);
    
    // Determinar la URL según el modo
    const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
    
    console.log('Guardando producto:', finalJSON, 'URL:', url);
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json;charset=UTF-8',
        data: productoJsonString,
        dataType: 'json',
        success: function(response) {
            console.log('Producto guardado:', response);
            let respuesta = response;
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            $('#product-result').removeClass('d-none');
            $('#container').html(template_bar);
            
            // Limpiar form
            $('#name').val('');
            $('#productId').val('');
            $('#product-form button[type="submit"]').text('Agregar Producto');
            init();
            
            edit = false;
            
            // Recargar listae productos
            listarProductos();
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar producto:', error);
            console.error('Response:', xhr.responseText);
            alert('Error al guardar producto. Revisa la consola (F12).');
        }
    });
}

// FUNCIÓN PARA ELIMINAR PRODUCTO
function eliminarProducto(id) {
    if (confirm("¿De verdad deseas eliminar el Producto?")) {
        console.log('Eliminando producto ID:', id);
        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                console.log('Producto eliminado:', response);
                let respuesta = response;
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                
                // Recargar lista de productos
                listarProductos();
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar producto:', error);
                console.error('Response:', xhr.responseText);
                alert('Error al eliminar producto. Revisa la consola (F12).');
            }
        });
    }
}