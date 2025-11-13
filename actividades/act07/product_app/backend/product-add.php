<?php 
use MyApi\Products; 
require_once __DIR__ . '/myapi/Products.php';

if (isset($_POST['nombre'])) {
    $products = new Products('marketzone');
    
    $jsonOBJ = json_decode(json_encode($_POST));
     
    $products->add($jsonOBJ);
    
    echo $products->getData();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos'], JSON_PRETTY_PRINT);
}