<?php
use MyApi\Products;

require_once __DIR__ . '/myapi/Products.php';

$data = array();

if (isset($_POST['id'])) {
    $products = new Products('marketzone');
    $id = $_POST['id'];

    $products->single($id);

    echo $products->getData();
    
} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}