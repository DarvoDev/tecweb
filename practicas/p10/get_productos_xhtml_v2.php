<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <title>Productos por unidades</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

    <h3>PRODUCTO</h3> 
    <br/>

<?php
    $productos = array();

    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];
    } else {
        die('Parámetro "tope" no detectado...');
    }

    if (!empty($tope)) {
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', '', 'marketzone');

        /** comprobar la conexión */
        if ($link->connect_errno) {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }

        if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= $tope") ) {
            /** Se extraen las tuplas obtenidas de la consulta */
            $productos = $result->fetch_all(MYSQLI_ASSOC);

            /** útil para liberar memoria asociada a un resultado con demasiada información */
            $result->free();
        }
        $link->close();
    }
?>

<?php if(!empty($productos)) : ?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Precio</th>
                <th scope="col">Unidades</th>
                <th scope="col">Detalles</th>
                <th scope="col">Imagen</th>
                <th scope="col">Modificar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto) : ?>
            <tr id="<?= $producto['id'] ?>">
                <th scope="row"><?= $producto['id'] ?></th>
                <td class="row-data"><?= $producto['nombre'] ?></td>
                <td class="row-data"><?= $producto['marca'] ?></td>
                <td class="row-data"><?= $producto['modelo'] ?></td>
                <td class="row-data"><?= $producto['precio'] ?></td>
                <td class="row-data"><?= $producto['unidades']?></td>
                <td class="row-data"><?= utf8_encode($producto['detalles']) ?></td>
                <td class="row-data"><img src="<?= $producto['imagen'] ?>" alt="Imagen del producto" style="max-width: 150px;"></td>
                <td><input type="button" value="Modificar" onclick="modificarProducto()"  /></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <div class = "alert alert-warning" role="alert">
        No se encontraron productos con unidades menores o iguales a <strong><?= $tope ?></strong>.
    </div>
<?php endif; ?>

<script>
    function modificarProducto() {
        // Obtener el ID de la fila donde está el botón presionado
        var rowId = event.target.parentNode.parentNode.id;
        
        // Obtener todos los datos de la fila con clase "row-data"
        var data = document.getElementById(rowId).querySelectorAll(".row-data");
        
        // Extraer cada dato
        var id = rowId;
        var nombre = data[0].innerHTML;
        var marca = data[1].innerHTML;
        var modelo = data[2].innerHTML;
        var precio = data[3].innerHTML;
        var unidades = data[4].innerHTML;
        var detalles = data[5].innerHTML;
        var imagen = data[6].firstChild.getAttribute('src');
        
        // Mostrar alert para confirmar (opcional, puedes quitarlo después)
        alert("Producto a modificar:\nID: " + id + "\nNombre: " + nombre);
        
        // Enviar los datos al formulario
        enviarFormulario(id, nombre, marca, modelo, precio, unidades, detalles, imagen);
    }

    function enviarFormulario(id, nombre, marca, modelo, precio, unidades, detalles, imagen) {
        
        var form = document.createElement("form");
        
        
        var inputId = document.createElement("input");
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = id;
        form.appendChild(inputId);
        
        var inputNombre = document.createElement("input");
        inputNombre.type = 'hidden';
        inputNombre.name = 'nombre';
        inputNombre.value = nombre;
        form.appendChild(inputNombre);
        
        var inputMarca = document.createElement("input");
        inputMarca.type = 'hidden';
        inputMarca.name = 'marca';
        inputMarca.value = marca;
        form.appendChild(inputMarca);
        
        var inputModelo = document.createElement("input");
        inputModelo.type = 'hidden';
        inputModelo.name = 'modelo';
        inputModelo.value = modelo;
        form.appendChild(inputModelo);
        
        var inputPrecio = document.createElement("input");
        inputPrecio.type = 'hidden';
        inputPrecio.name = 'precio';
        inputPrecio.value = precio;
        form.appendChild(inputPrecio);
        
        var inputUnidades = document.createElement("input");
        inputUnidades.type = 'hidden';
        inputUnidades.name = 'unidades';
        inputUnidades.value = unidades;
        form.appendChild(inputUnidades);
        
        var inputDetalles = document.createElement("input");
        inputDetalles.type = 'hidden';
        inputDetalles.name = 'detalles';
        inputDetalles.value = detalles;
        form.appendChild(inputDetalles);
        
        var inputImagen = document.createElement("input");
        inputImagen.type = 'hidden';
        inputImagen.name = 'imagen';
        inputImagen.value = imagen;
        form.appendChild(inputImagen);
        
        
        form.method = 'POST';
        form.action = 'http://localhost/tecweb/practicas/p10/formulario_productos_v2.php';
        
    
        document.body.appendChild(form);
        form.submit();
    }
    </script>

</body>
</html>