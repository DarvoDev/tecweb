<?php
$nombre   = trim($_POST['name']       ?? '');
$marca    = trim($_POST['brand']      ?? '');
$modelo   = trim($_POST['model']      ?? '');
$precio   = floatval($_POST['price']  ?? 0);
$detalles = trim($_POST['description']?? '');
$unidades = intval($_POST['stock']    ?? 0);

//imagen default
$imagenRuta = 'img/imagen.png';

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $carpetaDestino = 'img/';
    if (!file_exists($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    $nombreArchivo = basename($_FILES['image']['name']);
    $rutaDestino = $carpetaDestino . time() . '_' . $nombreArchivo;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $rutaDestino)) {
        $imagenRuta = $rutaDestino;
    }
}

@$link = new mysqli('localhost', 'root', '', 'marketzone');
if ($link->connect_errno) {
    die('<h2>Error de conexión a la base de datos</h2><p>' . $link->connect_error . '</p>');
}

$sqlCheck = "SELECT COUNT(*) AS total FROM productos WHERE nombre=? AND marca=? AND modelo=?";
$stmtCheck = $link->prepare($sqlCheck);
$stmtCheck->bind_param('sss', $nombre, $marca, $modelo);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$fila = $result->fetch_assoc();

if ($fila['total'] > 0) {
    // Producto duplicado
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head><meta charset="utf-8"><title>Resultado</title></head>
    <body>
        <h2>Error: Producto duplicado</h2>
        <p>Ya existe un producto con los siguientes datos:</p>
        <ul>
            <li><strong>Nombre:</strong> {$nombre}</li>
            <li><strong>Marca:</strong> {$marca}</li>
            <li><strong>Modelo:</strong> {$modelo}</li>
        </ul>
        <p><a href="formulario_productos.html"> Regresar al formulario</a></p>
    </body>
    </html>
    HTML;
    $stmtCheck->close();
    $link->close();
    exit;
}
$stmtCheck->close();

$sqlInsert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtInsert = $link->prepare($sqlInsert);
$stmtInsert->bind_param('sssdsis', $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagenRuta);
if ($stmtInsert->execute()) {
    $idInsertado = $stmtInsert->insert_id;

    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head><meta charset="utf-8"><title>Producto Insertado</title></head>
    <body>
        <h2>Producto insertado correctamente</h2>
        <ul>
            <li><strong>ID:</strong> {$idInsertado}</li>
            <li><strong>Nombre:</strong> {$nombre}</li>
            <li><strong>Marca:</strong> {$marca}</li>
            <li><strong>Modelo:</strong> {$modelo}</li>
            <li><strong>Precio:</strong> \${$precio}</li>
            <li><strong>Unidades:</strong> {$unidades}</li>
            <li><strong>Detalles:</strong> {$detalles}</li>
            <li><strong>Imagen:</strong><br><img src="{$imagenRuta}" alt="Imagen del producto" width="150"></li>
        </ul>
        <p><a href="formulario_productos.html"> Registrar otro producto</a></p>
    </body>
    </html>
    HTML;
} else {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head><meta charset="utf-8"><title>Error</title></head>
    <body>
        <h2>Error al insertar el producto</h2>
        <p>{$stmtInsert->error}</p>
        <p><a href="formulario_productos.html"> Regresar al formulario</a></p>
    </body>
    </html>
    HTML;
}

$stmtInsert->close();
$link->close();
?>

