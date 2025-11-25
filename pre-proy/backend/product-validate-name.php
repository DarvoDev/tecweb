<?php

use MyApi\Products;

require_once __DIR__ . '/myapi/Products.php';

$data = array('exists' => false);

if (isset($_POST['nombre'])) {
    $products = new Products('marketzone');
    $nombre = $_POST['nombre'];

    $products->validateName($nombre);
    
    echo $products->getData();
} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}