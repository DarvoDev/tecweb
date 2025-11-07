let edit = false;
let nombreValido = false;
let timeoutId = null;

$(document).ready(function() {
    $('#product-result').hide();
    listarProductos();

    // Validación del nombre con verificación asíncrona
    $('#name').on('blur', function() {
        validarNombre();
    });

    $('#name').on('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            validarNombre();
        }, 500);
    });

    // Validación de marca
    $('#marca').on('blur', function() {
        validarMarca();
    });

    // Validación de modelo
    $('#modelo').on('blur', function() {
        validarModelo();
    });

    // Validación de precio
    $('#precio').on('blur', function() {
        validarPrecio();
    });

    // Validación de unidades
    $('#unidades').on('blur', function() {
        validarUnidades();
    });

    // Validación de detalles
    $('#detalles').on('blur', function() {
        validarDetalles();
    });

    // Búsqueda de productos
    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + search,
                type: 'GET',
                success: function (response) {
                    const productos = JSON.parse(response);
                    
                    if(Object.keys(productos).length > 0) {
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
                                    <td><a href="#" class="product-item">${producto.nombre}</a></td>
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
                        
                        $('#product-result').show();
                        $('#container').html(template_bar);
                        $('#products').html(template);    
                    }
                }
            });
        } else {
            $('#product-result').hide();
            listarProductos();
        }
    });

    // Envío del formulario
    $('#product-form').submit(function(e) {
        e.preventDefault();
        agregarProducto();
    });

    // Eliminar producto
    $(document).on('click', '.product-delete', function(e) {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this).closest('tr');
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, function(response) {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    // Cargar producto para editar
    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
        const element = $(this).closest('tr');
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, function(response) {
            let product = JSON.parse(response);
            
            $('#name').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            
            $('#product-form button[type="submit"]').text('Actualizar Producto');
            
            edit = true;
            nombreValido = true;
        });
    });
});

// Función para validar el nombre
function validarNombre() {
    const nombre = $('#name').val().trim();
    const validationDiv = $('#name-validation');
    
    if (nombre === '') {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre es requerido');
        nombreValido = false;
        return false;
    }
    
    if (nombre.length > 100) {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre debe tener 100 caracteres o menos');
        nombreValido = false;
        return false;
    }
    
    // Validar que el nombre no exista en la BD (solo si no estamos editando)
    if (!edit) {
        $.ajax({
            url: './backend/product-validate-name.php',
            type: 'POST',
            data: { nombre: nombre },
            async: false,
            success: function(response) {
                const result = JSON.parse(response);
                if (result.exists) {
                    $('#name').removeClass('is-valid').addClass('is-invalid');
                    validationDiv.removeClass('valid').addClass('invalid').text('Este nombre ya existe en la base de datos');
                    nombreValido = false;
                } else {
                    $('#name').removeClass('is-invalid').addClass('is-valid');
                    validationDiv.removeClass('invalid').addClass('valid').text('Nombre válido y disponible');
                    nombreValido = true;
                }
            }
        });
    } else {
        $('#name').removeClass('is-invalid').addClass('is-valid');
        validationDiv.removeClass('invalid').addClass('valid').text('Nombre válido');
        nombreValido = true;
    }
    
    return nombreValido;
}

// Función para validar la marca
function validarMarca() {
    const marca = $('#marca').val().trim();
    const validationDiv = $('#marca-validation');
    
    if (marca === '' || marca === 'NA') {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca es requerida');
        return false;
    }
    
    $('#marca').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Marca válida');
    return true;
}

// Función para validar el modelo
function validarModelo() {
    const modelo = $('#modelo').val().trim();
    const validationDiv = $('#modelo-validation');
    const alfanumerico = /^[a-zA-Z0-9 ]+$/;
    
    if (modelo === '') {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo es requerido');
        return false;
    }
    
    if (modelo.length > 25) {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo debe tener 25 caracteres o menos');
        return false;
    }
    
    if (!alfanumerico.test(modelo)) {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo debe ser alfanumérico (letras, números y espacios)');
        return false;
    }
    
    $('#modelo').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Modelo válido');
    return true;
}

// Función para validar el precio
function validarPrecio() {
    const precio = parseFloat($('#precio').val());
    const validationDiv = $('#precio-validation');
    
    if (isNaN(precio)) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio debe ser un número válido');
        return false;
    }
    
    if (precio <= 99.99) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio debe ser mayor a 99.99');
        return false;
    }
    
    $('#precio').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Precio válido');
    return true;
}

// Función para validar las unidades
function validarUnidades() {
    const unidades = parseInt($('#unidades').val());
    const validationDiv = $('#unidades-validation');
    
    if (isNaN(unidades)) {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades deben ser un número válido');
        return false;
    }
    
    if (unidades < 0) {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades deben ser mayor o igual a 0');
        return false;
    }
    
    $('#unidades').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Unidades válidas');
    return true;
}

// Función para validar los detalles
function validarDetalles() {
    const detalles = $('#detalles').val().trim();
    const validationDiv = $('#detalles-validation');
    
    if (detalles.length > 250) {
        $('#detalles').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Los detalles deben tener 250 caracteres o menos');
        return false;
    }
    
    if (detalles.length > 0) {
        $('#detalles').removeClass('is-invalid').addClass('is-valid');
        validationDiv.removeClass('invalid').addClass('valid').text('Detalles válidos');
    } else {
        $('#detalles').removeClass('is-invalid is-valid');
        validationDiv.removeClass('invalid valid').text('');
    }
    return true;
}

// Función para listar productos
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            const productos = JSON.parse(response);
        
            if(Object.keys(productos).length > 0) {
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
                            <td><a href="#" class="product-item">${producto.nombre}</a></td>
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
            }
        }
    });
}

// Función para agregar o editar producto
function agregarProducto() {
    // Validar todos los campos antes de enviar
    const nombreOk = validarNombre();
    const marcaOk = validarMarca();
    const modeloOk = validarModelo();
    const precioOk = validarPrecio();
    const unidadesOk = validarUnidades();
    const detallesOk = validarDetalles();
    
    if (!nombreOk || !marcaOk || !modeloOk || !precioOk || !unidadesOk || !detallesOk) {
        mostrarEstado('error', 'Por favor corrige los errores en el formulario');
        return;
    }
    
    // Construir el objeto producto
    let postData = {
        nombre: $('#name').val().trim(),
        marca: $('#marca').val().trim(),
        modelo: $('#modelo').val().trim(),
        precio: parseFloat($('#precio').val()),
        unidades: parseInt($('#unidades').val()),
        detalles: $('#detalles').val().trim() || 'NA',
        imagen: $('#imagen').val().trim() || 'img/default.png'
    };
    
    if (edit) {
        postData.id = $('#productId').val();
    }
    
    const url = edit ? './backend/product-edit.php' : './backend/product-add.php';
    
    $.post(url, postData, function(response) {
        let respuesta = JSON.parse(response);
        mostrarEstado(respuesta.status, respuesta.message);
        
        // Limpiar formulario
        $('#name').val('');
        $('#marca').val('');
        $('#modelo').val('');
        $('#precio').val('');
        $('#unidades').val('1');
        $('#detalles').val('');
        $('#imagen').val('img/default.png');
        $('#productId').val('');
        
        // Limpiar clases de validación
        $('.form-control').removeClass('is-valid is-invalid');
        $('.validation-message').removeClass('valid invalid').text('');
        
        $('#product-form button[type="submit"]').text('Agregar Producto');
        
        edit = false;
        nombreValido = false;
        
        listarProductos();
    });
}

// Función para mostrar mensajes en la barra de estado
function mostrarEstado(status, message) {
    const template_bar = `
        <li style="list-style: none;">status: ${status}</li>
        <li style="list-style: none;">message: ${message}</li>
    `;
    $('#product-result').show();
    $('#container').html(template_bar);
    
    setTimeout(() => {
        $('#product-result').fadeOut();
    }, 3000);
}