<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos Vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>PRODUCTOS VIGENTES</h3>
    <br/>
    
    <?php
    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', '', 'marketzone');

    /** comprobar la conexión */
    if ($link->connect_errno) 
    {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }

    /** Consulta para obtener productos NO eliminados */
    if ( $result = $link->query("SELECT * FROM productos WHERE eliminado = 0") ) 
    {
        /** Se extraen las tuplas obtenidas de la consulta */
        $row = $result->fetch_all(MYSQLI_ASSOC);

        /** útil para liberar memoria asociada a un resultado con demasiada información */
        $result->free();
    }

    $link->close();
    ?>
    
    <?php if( isset($row) && count($row) > 0 ) : ?>
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
            <?php foreach($row as $value) : ?>
            <tr id="<?= $value['id'] ?>">
                <th scope="row"><?= $value['id'] ?></th>
                <td class="row-data"><?= $value['nombre'] ?></td>
                <td class="row-data"><?= $value['marca'] ?></td>
                <td class="row-data"><?= $value['modelo'] ?></td>
                <td class="row-data"><?= $value['precio'] ?></td>
                <td class="row-data"><?= $value['unidades'] ?></td>
                <td class="row-data"><?= utf8_encode($value['detalles']) ?></td>
                <td class="row-data"><img src="<?= $value['imagen'] ?>" width="100"></td>
                <td><input type="button" value="Modificar" onclick="modificarProducto()" /></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    <?php else : ?>
        <p>No hay productos vigentes para mostrar.</p>
    <?php endif; ?>

    <script>
        function modificarProducto() {
            var rowId = event.target.parentNode.parentNode.id;
            
            var data = document.getElementById(rowId).querySelectorAll(".row-data");
            
            var id = rowId;
            var nombre = data[0].innerHTML;
            var marca = data[1].innerHTML;
            var modelo = data[2].innerHTML;
            var precio = data[3].innerHTML;
            var unidades = data[4].innerHTML;
            var detalles = data[5].innerHTML;
            var imagen = data[6].firstChild.getAttribute('src');
            
            alert("Producto a modificar:\nID: " + id + "\nNombre: " + nombre);
            
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
            
            // Configurar el formulario
            form.method = 'POST';
            form.action = 'http://localhost/tecweb/practicas/p10/formulario_productos_v2.php';
            
            // Agregar el formulario al body y enviarlo
            document.body.appendChild(form);
            form.submit();
        }
    </script>

</body>
</html>