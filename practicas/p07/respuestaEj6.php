<?php
require_once 'src/funciones.php';

if (isset($_POST['buscar'])) {
    $matricula = $_POST['matricula'];
    $resultado = buscarAutoPorMatricula($matricula);

    if ($resultado) {
        echo "<h3>Resultado para matrícula $matricula:</h3>";
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    } else {
        echo "<p style='color:red;'>No se encontró la matrícula $matricula</p>";
    }
}

if (isset($_POST['todos'])) {
    echo "<h3>Listado completo del parque vehicular:</h3>";
    echo "<pre>";
    print_r(mostrarTodosAutos());
    echo "</pre>";
}
?>
