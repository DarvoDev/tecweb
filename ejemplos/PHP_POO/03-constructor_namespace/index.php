<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>03-Consructor y namespaces</title>
</head>
<body>
    <?php
        use EJEMPLOS\PHP\Cabecera2 as Cabecera;
        require_once __DIR__.'/Cabecera.php';


        $cab1 = new Cabecera('El rincon del Programador', 'center', 'https://cs.buap.mx');
        $cab1->graficar();
    ?>
</body>
</html>