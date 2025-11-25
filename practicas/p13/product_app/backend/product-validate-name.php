<?php
    use TECWEB\MYAPI\Read\Read;
    require_once __DIR__.'/vendor/autoload.php';

    $productos = new Read('marketzone');
    
    if(isset($_POST['nombre'])) {
        $productos->checkName($_POST['nombre']);
        echo $productos->getData();
    } else {
        echo json_encode(['exists' => false, 'error' => 'No se recibió el nombre']);
    }
?>