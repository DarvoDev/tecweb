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
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto) : ?>
            <tr>
                <th scope="row"><?= $producto['id'] ?></th>
                <td><?= $producto['nombre'] ?></td>
                <td><?= $producto['marca'] ?></td>
                <td><?= $producto['modelo'] ?></td>
                <td><?= $producto['precio'] ?></td>
                <td><?= $producto['unidades']?></td>
                <td><?= utf8_encode($producto['detalles']) ?></td>
                <td><img src="<?= $producto['imagen'] ?>" alt="Imagen del producto" style="max-width: 150px;"></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <div class = "alert alert-warning" role="alert">
        No se encontraron productos con unidades menores o iguales a <strong><?= $tope ?></strong>.
    </div>
<?php endif; ?>

</body>
</html>