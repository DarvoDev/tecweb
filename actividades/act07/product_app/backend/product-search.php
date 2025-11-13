<?php

use MyApi\Products;
require_once __DIR__ . '/myapi/Products.php';

$data = array();

if (isset($_GET['search'])) {
    $products = new Products('marketzone');
    $search = $_GET['search'];

    $products->search($search);
    
    echo $products->getData();

} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}