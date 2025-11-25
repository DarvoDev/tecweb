// Variable global para controlar edición
let edit = false;
let nombreValido = false;
let timeoutId = null;

$(document).ready(function() {
    $('#product-result').hide();
    listarProductos();

    // ==========================================
    // EVENTS LISTENERS PARA VALIDACIÓN EN TIEMPO REAL
    // ==========================================
    
    // Nombre: valida al escribir (con delay) y al salir del campo
    $('#name').on('blur', function() { validarNombre(); });
    $('#name').on('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => { validarNombre(); }, 500);
    });

    // Otros campos: validan al escribir y al salir del campo
    $('#marca').on('blur', function() { validarMarca(); });
    $('#marca').on('input', function() { validarMarca(); });
    
    $('#modelo').on('blur', function() { validarModelo(); });
    $('#modelo').on('input', function() { validarModelo(); });
    
    $('#precio').on('blur', function() { validarPrecio(); });
    $('#precio').on('input', function() { validarPrecio(); });
    
    $('#unidades').on('blur', function() { validarUnidades(); });
    $('#unidades').on('input', function() { validarUnidades(); });
    
    $('#detalles').on('blur', function() { validarDetalles(); });
    $('#detalles').on('input', function() { 
        actualizarContador();
        validarDetalles(); 
    });
    
    $('#imagen').on('blur', function() { validarImagen(); });
    $('#imagen').on('input', function() { validarImagen(); });

    // Contador de caracteres para detalles
    actualizarContador();

    // ==========================================
    // FUNCIONES DE CRUD
    // ==========================================

    // Búsqueda de productos
    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + search,
                type: 'GET',
                dataType: 'json',
                success: function (productos) {
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
                                    <button class="product-delete btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        `;
                        template_bar += `<li>${producto.nombre}</li>`;
                    });
                    
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    $('#products').html(template); 
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
            $.ajax({
                url: './backend/product-delete.php',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(respuesta) {
                    mostrarEstado(respuesta.status, respuesta.message);
                    listarProductos();
                },
                error: function(xhr) {
                    console.error("Error al eliminar:", xhr.responseText);
                    mostrarEstado('error', 'Error al eliminar el producto');
                }
            });
        }
    });

    // Cargar producto para editar
    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
        const element = $(this).closest('tr');
        const id = $(element).attr('productId');
        $.ajax({
            url: './backend/product-single.php',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(product) {
            
            $('#name').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            
            $('#product-form button[type="submit"]').text('Actualizar Producto');
            
            // Validamos campos visualmente al cargar
            validarNombre();
            validarMarca();
            validarModelo();
            validarPrecio();
            validarUnidades();
            validarDetalles();
            validarImagen();
            actualizarContador();
            
            edit = true;
            nombreValido = true;
        },
        error: function(xhr) {
            console.error("Error al cargar producto:", xhr.responseText);
            mostrarEstado('error', 'Error al cargar el producto');
        }
    });
    });
});

// ==========================================
// FUNCIONES DE VALIDACIÓN VISUAL
// ==========================================

function validarNombre() {
    const nombre = $('#name').val().trim();
    const validationDiv = $('#name-validation');
    
    // Validar campo vacío
    if (nombre === '') {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre es requerido');
        nombreValido = false;
        return false;
    }
    
    // Validar longitud mínima
    if (nombre.length < 3) {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre debe tener al menos 3 caracteres');
        nombreValido = false;
        return false;
    }
    
    // Validar longitud máxima
    if (nombre.length > 100) {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre debe tener 100 caracteres o menos');
        nombreValido = false;
        return false;
    }
    
    // Validar caracteres especiales peligrosos
    const caracteresProhibidos = /[<>\"\']/;
    if (caracteresProhibidos.test(nombre)) {
        $('#name').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El nombre contiene caracteres no permitidos');
        nombreValido = false;
        return false;
    }
    
    // Validación Ajax de nombre duplicado
    if (!edit) {
        $.ajax({
            url: './backend/product-validate-name.php',
            type: 'POST',
            data: { nombre: nombre },
            async: false,
            dataType: 'json',
            success: function(result) {
                if (result.exists) {
                    $('#name').removeClass('is-valid').addClass('is-invalid');
                    validationDiv.removeClass('valid').addClass('invalid').text('Este nombre ya existe en la base de datos');
                    nombreValido = false;
                } else {
                    $('#name').removeClass('is-invalid').addClass('is-valid');
                    validationDiv.removeClass('invalid').addClass('valid').text('Nombre válido y disponible');
                    nombreValido = true;
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en validación de nombre:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                $('#name').removeClass('is-valid').addClass('is-invalid');
                validationDiv.removeClass('valid').addClass('invalid').text('Error al validar el nombre con el servidor');
                nombreValido = false;
            }
        });
    } else {
        $('#name').removeClass('is-invalid').addClass('is-valid');
        validationDiv.removeClass('invalid').addClass('valid').text('Nombre válido');
        nombreValido = true;
    }
    return nombreValido;
}

function validarMarca() {
    const marca = $('#marca').val().trim();
    const validationDiv = $('#marca-validation');
    
    // Validar campo vacío
    if (marca === '') {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca es requerida');
        return false;
    }
    
    // Validar que no sea "NA"
    if (marca.toUpperCase() === 'NA') {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca no puede ser "NA"');
        return false;
    }
    
    // Validar longitud mínima
    if (marca.length < 2) {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca debe tener al menos 2 caracteres');
        return false;
    }
    
    // Validar longitud máxima
    if (marca.length > 50) {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca debe tener 50 caracteres o menos');
        return false;
    }
    
    // Validar caracteres especiales peligrosos
    const caracteresProhibidos = /[<>\"\']/;
    if (caracteresProhibidos.test(marca)) {
        $('#marca').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La marca contiene caracteres no permitidos');
        return false;
    }
    
    $('#marca').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Marca válida');
    return true;
}

function validarModelo() {
    const modelo = $('#modelo').val().trim();
    const validationDiv = $('#modelo-validation');
    
    // Validar campo vacío
    if (modelo === '') {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo es requerido');
        return false;
    }
    
    // Validar longitud mínima
    if (modelo.length < 2) {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo debe tener al menos 2 caracteres');
        return false;
    }
    
    // Validar longitud máxima
    if (modelo.length > 25) {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo debe tener 25 caracteres o menos');
        return false;
    }
    
    // Validar formato alfanumérico (letras, números, espacios y guiones)
    const alfanumerico = /^[a-zA-Z0-9\s\-]+$/;
    if (!alfanumerico.test(modelo)) {
        $('#modelo').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El modelo debe ser alfanumérico (letras, números, espacios y guiones)');
        return false;
    }
    
    $('#modelo').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Modelo válido');
    return true;
}

function validarPrecio() {
    const precioStr = $('#precio').val().trim();
    const precio = parseFloat(precioStr);
    const validationDiv = $('#precio-validation');
    
    // Validar campo vacío
    if (precioStr === '') {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio es requerido');
        return false;
    }
    
    // Validar que sea un número
    if (isNaN(precio)) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio debe ser un número válido');
        return false;
    }
    
    // Validar que sea mayor a 99.99
    if (precio <= 99.99) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio debe ser mayor a 99.99');
        return false;
    }
    
    // Validar que no sea negativo
    if (precio < 0) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio no puede ser negativo');
        return false;
    }
    
    // Validar límite superior razonable
    if (precio > 999999.99) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio es demasiado alto (máximo: 999,999.99)');
        return false;
    }
    
    // Validar máximo 2 decimales
    const decimales = (precioStr.split('.')[1] || '').length;
    if (decimales > 2) {
        $('#precio').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('El precio debe tener máximo 2 decimales');
        return false;
    }
    
    $('#precio').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Precio válido');
    return true;
}

function validarUnidades() {
    const unidadesStr = $('#unidades').val().trim();
    const unidades = parseInt(unidadesStr);
    const validationDiv = $('#unidades-validation');
    
    // Validar campo vacío
    if (unidadesStr === '') {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades son requeridas');
        return false;
    }
    
    // Validar que sea un número entero
    if (isNaN(unidades) || !Number.isInteger(parseFloat(unidadesStr))) {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades deben ser un número entero');
        return false;
    }
    
    // Validar que no sea negativo
    if (unidades < 0) {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades no pueden ser negativas');
        return false;
    }
    
    // Validar límite superior razonable
    if (unidades > 1000000) {
        $('#unidades').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Las unidades son demasiado altas (máximo: 1,000,000)');
        return false;
    }
    
    $('#unidades').removeClass('is-invalid').addClass('is-valid');
    validationDiv.removeClass('invalid').addClass('valid').text('Unidades válidas');
    return true;
}

function validarDetalles() {
    const detalles = $('#detalles').val();
    const validationDiv = $('#detalles-validation');
    
    // Validar longitud máxima
    if (detalles.length > 250) {
        $('#detalles').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Los detalles deben tener 250 caracteres o menos');
        return false;
    }
    
    // Validar caracteres especiales peligrosos
    const caracteresProhibidos = /[<>\"\']/;
    if (caracteresProhibidos.test(detalles)) {
        $('#detalles').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('Los detalles contienen caracteres no permitidos');
        return false;
    }
    
    // Si tiene contenido, marcarlo como válido
    if (detalles.length > 0) {
        $('#detalles').removeClass('is-invalid').addClass('is-valid');
        validationDiv.removeClass('invalid').addClass('valid').text('Detalles válidos');
    } else {
        // Si está vacío es válido pero neutral
        $('#detalles').removeClass('is-invalid is-valid');
        validationDiv.removeClass('invalid valid').text('');
    }
    return true;
}

function validarImagen() {
    const imagen = $('#imagen').val().trim();
    const validationDiv = $('#imagen-validation');
    
    // Si está vacío, asignar valor por defecto
    if (imagen === '') {
        $('#imagen').val('img/default.png');
        $('#imagen').removeClass('is-invalid is-valid');
        validationDiv.removeClass('invalid valid').text('');
        return true;
    }
    
    // Validar longitud máxima
    if (imagen.length > 200) {
        $('#imagen').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La ruta de imagen es demasiado larga (máximo: 200 caracteres)');
        return false;
    }
    
    // Validar formato de ruta de imagen
    const formatoImagen = /\.(jpg|jpeg|png|gif|webp|svg)$/i;
    if (!formatoImagen.test(imagen)) {
        $('#imagen').removeClass('is-valid').addClass('is-warning');
        validationDiv.removeClass('invalid valid').addClass('warning').text('Advertencia: La ruta no termina con una extensión de imagen válida');
        return true; // Permitir pero advertir
    }
    
    // Validar caracteres especiales peligrosos
    const caracteresProhibidos = /[<>\"\']/;
    if (caracteresProhibidos.test(imagen)) {
        $('#imagen').removeClass('is-valid').addClass('is-invalid');
        validationDiv.removeClass('valid').addClass('invalid').text('La ruta contiene caracteres no permitidos');
        return false;
    }
    
    $('#imagen').removeClass('is-invalid is-warning').addClass('is-valid');
    validationDiv.removeClass('invalid warning').addClass('valid').text('Ruta válida');
    return true;
}

function actualizarContador() {
    const detalles = $('#detalles').val();
    $('#detalles-counter').text(detalles.length);
}

// ==========================================
// FUNCIÓN PRINCIPAL DE AGREGAR CON VALIDACIÓN COMPLETA
// ==========================================

function agregarProducto() {
    // Validar todos los campos antes de enviar
    const nombreOk = validarNombre();
    const marcaOk = validarMarca();
    const modeloOk = validarModelo();
    const precioOk = validarPrecio();
    const unidadesOk = validarUnidades();
    const detallesOk = validarDetalles();
    const imagenOk = validarImagen();
    
    // Si alguna validación falla, no enviar
    if (!nombreOk || !marcaOk || !modeloOk || !precioOk || !unidadesOk || !detallesOk || !imagenOk) {
        mostrarEstado('error', 'Por favor corrige los errores en el formulario antes de continuar');
        // Hacer scroll al primer campo con error
        $('.is-invalid').first().focus();
        return;
    }
    
    // Sanitizar y preparar datos
    let postData = {
        nombre: sanitizarTexto($('#name').val().trim()),
        marca: sanitizarTexto($('#marca').val().trim()),
        modelo: sanitizarTexto($('#modelo').val().trim()),
        precio: parseFloat($('#precio').val()),
        unidades: parseInt($('#unidades').val()),
        detalles: sanitizarTexto($('#detalles').val().trim()) || 'NA',
        imagen: sanitizarTexto($('#imagen').val().trim()) || 'img/default.png'
    };
    
    // Validación final antes de enviar
    if (!validarDatosFinales(postData)) {
        mostrarEstado('error', 'Error en la validación final de los datos');
        return;
    }
    
    if (edit) {
        postData.id = $('#productId').val();
    }
    
    const url = edit ? './backend/product-edit.php' : './backend/product-add.php';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: postData,
        dataType: 'json',
        success: function(respuesta) {
            mostrarEstado(respuesta.status, respuesta.message);
            
            if (respuesta.status === 'success') {
                // Limpiar formulario y quitar validaciones visuales
                $('#product-form').trigger('reset');
                $('#imagen').val('img/default.png');
                $('#productId').val('');
                $('#product-form button[type="submit"]').text('Agregar Producto');
                
                // Limpieza visual profunda
                $('.form-control').removeClass('is-valid is-invalid is-warning');
                $('.validation-message').removeClass('valid invalid warning').text('');
                $('#detalles-counter').text('0');
                
                edit = false;
                nombreValido = false;
                
                listarProductos();
            }
        },
        error: function(xhr) {
            console.error("Error al guardar producto:", xhr.responseText);
            mostrarEstado('error', 'Error al comunicarse con el servidor');
        }
    });
}

// ==========================================
// FUNCIONES DE SANITIZACIÓN Y VALIDACIÓN FINAL
// ==========================================

function sanitizarTexto(texto) {
    // Eliminar espacios múltiples
    texto = texto.replace(/\s+/g, ' ');
    // Eliminar caracteres peligrosos
    texto = texto.replace(/[<>\"\']/g, '');
    return texto.trim();
}

function validarDatosFinales(datos) {
    // Validación final de todos los campos antes de enviar
    if (!datos.nombre || datos.nombre.length < 3 || datos.nombre.length > 100) {
        return false;
    }
    if (!datos.marca || datos.marca.length < 2 || datos.marca.length > 50) {
        return false;
    }
    if (!datos.modelo || datos.modelo.length < 2 || datos.modelo.length > 25) {
        return false;
    }
    if (isNaN(datos.precio) || datos.precio <= 99.99 || datos.precio > 999999.99) {
        return false;
    }
    if (isNaN(datos.unidades) || datos.unidades < 0 || datos.unidades > 1000000) {
        return false;
    }
    if (datos.detalles.length > 250) {
        return false;
    }
    if (datos.imagen.length > 200) {
        return false;
    }
    return true;
}

// ==========================================
// FUNCIONES AUXILIARES
// ==========================================

function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        dataType: 'json',
        success: function(productos) {
            if(Object.keys(productos).length > 0) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td><a href="#" class="product-item">${producto.nombre}</a></td>
                            <td><ul>${descripcion}</ul></td>
                            <td><button class="product-delete btn btn-danger">Eliminar</button></td>
                        </tr>
                    `;
                });
                $('#products').html(template);
            }
        },
        error: function(xhr) {
            console.error("Error al listar productos:", xhr.responseText);
        }
    });
}

function mostrarEstado(status, message) {
    const statusClass = status === 'success' ? 'text-success' : 'text-danger';
    const template_bar = `
        <li style="list-style: none;" class="${statusClass}"><strong>Status:</strong> ${status}</li>
        <li style="list-style: none;" class="${statusClass}"><strong>Mensaje:</strong> ${message}</li>
    `;
    $('#product-result').show();
    $('#container').html(template_bar);
    setTimeout(() => { $('#product-result').fadeOut(); }, 4000);
}