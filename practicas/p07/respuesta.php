<?php
require_once 'src/funciones.php';

if ($_POST && isset($_POST['name']) && isset($_POST['email'])) {
    $nombre = $_POST['name'];
    $correo = $_POST['email'];

    echo mostrarDatos($nombre, $correo);
} else {
    echo "<h3>Faltan datos del formulario.</h3>";
}

if ($_POST && isset($_POST['edad']) && isset($_POST['sexo'])) {
    $edad = (int)$_POST['edad'];
    $sexo = $_POST['sexo'];

    echo validarEdadSexo($edad, $sexo);
} else {
    echo "<h3>Faltan datos del formulario.</h3>";
}
?>