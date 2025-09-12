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

    <h2>Ejercicio 5</h2>
    <?php
        $a = "7 personas";
        echo "\$a = $a<br>";
        $b = (integer) $a;  
        echo "\$b = $b<br>";
        $a = "9E3";
        echo "\$a = $a<br>";
        $c = (double) $a;   
        echo "\$c = $c<br>";
    ?>

    <h2>Ejercicio 6</h2>
    <?php
    $a = "0";
    $b = "TRUE";
    $c = FALSE;
    $d = ($a OR $b);   // "0" (false) OR "TRUE" (true) → true
    $e = ($a AND $c);  // "0" (false) AND false → false
    $f = ($a XOR $b);  // false XOR true → true

    echo "<h3>Valores con var_dump()</h3>";
    var_dump($a); echo "<br>";
    var_dump($b); echo "<br>";
    var_dump($c); echo "<br>";
    var_dump($d); echo "<br>";
    var_dump($e); echo "<br>";
    var_dump($f); echo "<br>";

    // Para mostrar FALSE/TRUE con echo
    echo "<h3>Mostrando valores booleanos de \$c y \$e con var_export()</h3>";
    echo "c = " . var_export($c, true) . "<br>";
    echo "e = " . var_export($e, true) . "<br>";
    ?>

    <h2>Ejercicio 7</h2>
    <?php
        echo "<h3>Información del servidor y cliente</h3>";

        // a) Versión de Apache y PHP
        echo "PHP version: " . phpversion() . "<br>";
        echo "Software del servidor (Apache): " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

        // b) Sistema operativo del servidor
        echo "Sistema operativo del servidor: " . PHP_OS . "<br>";

        // c) Idioma del navegador
        echo "Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";
    ?>




    
</body>
</html>