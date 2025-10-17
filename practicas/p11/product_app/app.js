// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function buscarProducto(e){
    e.preventDefault();

    //SE OBTIENE EL TERMINO A BUSCAR
    var search = document.getElementById('search').value;

    //SE CREA EL OBJETO DE CONEXION ASINCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function(){
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if(client.readyState == 4 && client.status == 200){
            console.log('[CLIENTE\n]' + client.responseText);

            //SE OBTIENE EL ARRAY DE PRODUCTOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);

            //se verifica sI EL ARRAY TIENE DATOS
            if(productos.length>0){
                let template = '';

                //se recorre cada producto y se genera su fila
                productos.forEach(function(producto){
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';


                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                     `;   
                });

                //SE INCERTA LA PLANTILLA ENL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }else{
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos</td></tr>';
            }
        }
    };
    client.send("search="+search);
}


function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL NOMBRE DEL PRODUCTO
    var nombre = document.getElementById('name').value.trim();
    
    // SE OBTIENE Y PARSEA EL JSON DEL FORMULARIO
    var productoJsonString = document.getElementById('description').value;
    var finalJSON;
    
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch(error) {
        window.alert('Error: El JSON no es válido');
        return;
    }

    // Nombre requerido y <= 100 caracteres
    if (!nombre || nombre.length > 100) {
        window.alert('El nombre es requerido y debe tener 100 caracteres o menos.');
        return;
    }

    // Marca requerida
    if (!finalJSON.marca || finalJSON.marca === 'NA' || finalJSON.marca.trim() === '') {
        window.alert('La marca es requerida.');
        return;
    }

    // Modelo requerido, alfanumérico y <= 25 caracteres
    var alfanumerico = /^[a-zA-Z0-9]+$/;
    if (!finalJSON.modelo || finalJSON.modelo.length > 25) {
        window.alert('El modelo es requerido y debe tener 25 caracteres o menos.');
        return;
    }
    if (!alfanumerico.test(finalJSON.modelo)) {
        window.alert('El modelo debe ser alfanumérico (solo letras y números).');
        return;
    }

    // Precio requerido y > 99.99
    var precio = parseFloat(finalJSON.precio);
    if (isNaN(precio) || precio <= 99.99) {
        window.alert('El precio debe ser mayor a 99.99');
        return;
    }

    // Detalles opcionales pero <= 250 caracteres
    if (finalJSON.detalles && finalJSON.detalles !== 'NA' && finalJSON.detalles.length > 250) {
        window.alert('Los detalles deben tener 250 caracteres o menos.');
        return;
    }

    // Unidades requeridas y >= 0
    var unidades = parseInt(finalJSON.unidades);
    if (isNaN(unidades) || unidades < 0) {
        window.alert('Las unidades son requeridas y deben ser mayor o igual a 0.');
        return;
    }

    // VALIDACIÓN 7: Imagen por defecto si no se proporciona
    if (!finalJSON.imagen || finalJSON.imagen.trim() === '') {
        finalJSON.imagen = 'img/default.png';
    }

    // SE AGREGA EL NOMBRE AL JSON
    finalJSON['nombre'] = nombre;
    
    // SE CONVIERTE EL JSON FINAL A STRING
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            // SE MUESTRA EL MENSAJE DEL SERVIDOR AL USUARIO
            window.alert(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}