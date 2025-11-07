<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array('exists' => false);

    if(isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        
        // SE REALIZA LA QUERY DE BÚSQUEDA
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        $result = $conexion->query($sql);
        
        if ($result->num_rows > 0) {
            $data['exists'] = true;
        }

        $result->free();
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>