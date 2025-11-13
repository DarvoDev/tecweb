<?php
use MyApi\Products;

require_once __DIR__ . '/myapi/Products.php';

$data = array(
    'status'  => 'error',
    'message' => 'La consulta falló'
);

if (isset($_POST['id'])) {
    $products = new Products('marketzone');
    $id = $_POST['id'];

    $products->delete($id);

    echo $products->getData();

} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}