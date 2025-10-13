<?php
$id = $_POST['id'];
$nombre = $_POST['name'];
$marca = $_POST['brand'];
$modelo = $_POST['model'];
$precio = $_POST['price'];
$detalles = $_POST['description'];
$unidades = $_POST['stock'];

$imagen = $_POST['imagen_actual']; 
//por defecto se usa la imagen actual

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $nombreArchivo = $_FILES['image']['name'];
    $rutaTemporal = $_FILES['image']['tmp_name'];
    $carpetaDestino = 'img/';
    
    if (!file_exists($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }
    
    $rutaFinal = $carpetaDestino . $nombreArchivo;
    
    if(move_uploaded_file($rutaTemporal, $rutaFinal)) {
        $imagen = $rutaFinal;
    }
} else if(isset($_POST['imagen_defecto'])) {
    $imagen = $_POST['imagen_defecto'];
}

@$link = new mysqli('localhost', 'root', '', 'marketzone');

if($link->connect_errno) {
    die("ERROR: No pudo conectarse con la DB. " . $link->connect_error);
}

$sql = "UPDATE productos SET 
        nombre = '{$nombre}', 
        marca = '{$marca}', 
        modelo = '{$modelo}', 
        precio = {$precio}, 
        detalles = '{$detalles}', 
        unidades = {$unidades}, 
        imagen = '{$imagen}' 
        WHERE id = {$id}";

if(mysqli_query($link, $sql)) {
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Producto Actualizado</title>
    
    </head>
    <body>
        <div
            <div role="alert">
                <h4 >Producto actualizado exitosamente</h4>
                <hr>
                <p><strong>ID:</strong> '.$id.'</p>
                <p><strong>Nombre:</strong> '.$nombre.'</p>
                <p><strong>Marca:</strong> '.$marca.'</p>
                <p><strong>Modelo:</strong> '.$modelo.'</p>
                <p><strong>Precio:</strong> $'.$precio.'</p>
                <p><strong>Unidades:</strong> '.$unidades.'</p>
                <p><strong>Detalles:</strong> '.$detalles.'</p>
                <p><strong>Imagen:</strong> '.$imagen.'</p>
            </div>
            <a href="get_productos_vigentes_v2.php" class="btn btn-primary">Ver todos los productos</a>
            <a href="get_productos_xhtml_v2.php?tope=10" class="btn btn-secondary">Ver productos por tope</a>
        </div>
    </body>
    </html>';
} else {
    echo "ERROR: No se ejecutó la consulta. " . mysqli_error($link);
}

mysqli_close($link);
?>