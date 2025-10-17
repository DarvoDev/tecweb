<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        // SE EXTRAEN LOS DATOS DEL PRODUCTO
        $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
        $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
        $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
        $precio = $jsonOBJ->precio;
        $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
        $unidades = $jsonOBJ->unidades;
        $imagen = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);
        
        // SE VERIFICA SI EL PRODUCTO YA EXISTE 
        $sql_check = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        $resultado = $conexion->query($sql_check);
        
        if($resultado->num_rows > 0) {
            // EL PRODUCTO YA EXISTE
            echo "Error: El producto '{$nombre}' ya existe en la base de datos.";
        } else {
            // EL PRODUCTO NO EXISTE, SE PROCEDE A INSERTAR
            $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                          VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";
            
            if($conexion->query($sql_insert)) {
                echo "Producto agregado exitosamente. ID: " . $conexion->insert_id;
            } else {
                echo "Error al agregar el producto: " . mysqli_error($conexion);
            }
        }
        
        $conexion->close();
    } else {
        echo "Error: No se recibió información del producto.";
    }
?>