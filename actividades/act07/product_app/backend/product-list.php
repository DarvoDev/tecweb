<?php
// 1. Uso del namespace 
use MyApi\Products;

// 2. Inclusión del archivo de la clase 
require_once __DIR__ . '/myapi/Products.php';

$products = new Products('marketzone');

$products->list();
echo $products->getData();
