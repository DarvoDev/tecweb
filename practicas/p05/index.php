<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>

    <h2>Ejercicio 2</h2>
    <?php
    $a = "ManejadorSQL";
    $b = "MySQL";
    $c = &$a; // c referencia a a

    echo "<strong>Bloque 1:</strong><br>";
    echo "a = $a<br>";
    echo "b = $b<br>";
    echo "c = $c<br>";

    echo "<br>";

    // reasignamos
    $a = "PHP server";
    $b = &$a; // ahora b referencia a a también

    echo "<strong>Bloque 2 (después de cambios):</strong><br>";
    echo "a = $a<br>";
    echo "b = $b<br>";
    echo "c = $c<br>";

    ?>

    <h2>Ejercicio 3</h2>
    <?php
        $a = "PHP5"; // 1
        echo "\$a = $a<br>";
        $z[] = &$a; // 2
        echo "\$z = ";
        print_r($z);
        echo "<br>";
        $b = "5a version de PHP"; // 3
        echo "\$b = $b<br>";
        $c = $b*10; // 4
        echo "\$c = $c<br>";

        $a .= $b; // 5
        echo "\$a = $a<br>";

        $b *= $c; // 6
        echo "\$b = $b<br>";

        $z[0] = "MySQL"; // 7
        echo "\$z[0] = $z[0]<br>";
        echo "\$a = $a<br>";
    ?>

    <h2>Ejercicio 4</h2>
    <?php
        $a = "PHP5"; // 1
        echo "\$a = " . $GLOBALS['a'] . "<br>";

        $z[] = &$a; // 2
        echo "\$z = ";
        print_r($GLOBALS['z']);
        echo "<br>";

        $b = "5a version de PHP"; // 3
        echo "\$b = " . $GLOBALS['b'] . "<br>";

        $c = $GLOBALS['b'] * 10; // 4
        echo "\$c = " . $GLOBALS['c'] . "<br>";

        $GLOBALS['a'] .= $GLOBALS['b']; // 5
        echo "\$a = " . $GLOBALS['a'] . "<br>";

        $GLOBALS['b'] *= $GLOBALS['c']; // 6
        echo "\$b = " . $GLOBALS['b'] . "<br>";

        $GLOBALS['z'][0] = "MySQL"; // 7
        echo "\$z[0] = " . $GLOBALS['z'][0] . "<br>";
        echo "\$a = " . $GLOBALS['a'] . "<br>";
    ?>

    
</body>
</html>