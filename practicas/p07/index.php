<?php require_once 'src/funciones.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    
    <?php
       echo esMultiploDe5y7();
    ?>

    <br>
    

    <h2>Ejercicio 2</h2>
    <?php
        echo generarNumeros();
    ?>

    <h2>Ejercicio 3</h2>
    <?php 
        echo obtenerNumero();
        echo obtenerNumero2();
    ?>

    <h2>Ejercicio 4</h2>
    <?php 
        echo abecedario();
    ?>

    <br>
    <h2>Ejercicio 5</h2>
    <form action="respuesta.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>

 
    <br>
    
    <label for="edad">Edad:</label>
    <input type="number" id="edad" name="edad" required min="1" max="120"> 
    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
        <option value="">Seleccionar...</option>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
    </select>
        
    <input type="submit" value="Enviar">
    </form>

     <h2>Ejercicio 6</h2>
    <form action="respuestaEj6.php" method="post">
        <label>Matrícula:</label>
        <input type="text" name="matricula" placeholder="Ej. ABC1234"><br><br>
        <input type="submit" name="buscar" value="Buscar por Matrícula">
        <input type="submit" name="todos" value="Mostrar Todos">
    </form>


    
</body>
</html>