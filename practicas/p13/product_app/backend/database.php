<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'nomeacuerdo',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>