<?php
// |========================= EJERCICIO 1 =========================|
function esMultiploDe5y7(){
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            if ($num%5==0 && $num%7==0)
            {
                return '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            }
            else
            {
                return '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
        }
    }

// |========================= EJERCICIO 2 =========================|
function esPar($n){
    return $n%2 == 0;
}

function esImpar($n){
    return $n%2!=0;
}

function generarNumeros(){
    $encontrado = FALSE;
    $matriz = [];
    $nfila = 0;
    $iteraciones = 0;
    while(!$encontrado){
        $iteraciones++;
        $fila = [rand(0,999), rand(0,999), rand(0,999)];
        $matriz[] = $fila;
        echo "$fila[0], $fila[1], $fila[2]<br>";
        //impar par impar
        if(esImpar($fila[0]) and esPar($fila[1]) and esImpar($fila[2])){
            $encontrado = TRUE;
        }
        
    }

    return '<h3>R= ' . ($iteraciones * 3) . ' numeros obtenidos en ' . $iteraciones . ' iteraciones</h3>';
}

// |========================= EJERCICIO 3 =========================|

function obtenerNumero(){
    $encontrado = FALSE;
    if(isset($_GET['numero'])){
            $num = $_GET['numero'];
            while(!$encontrado){
                $aleatorio = rand();
                if($aleatorio % $num == 0){
                    $encontrado = TRUE;
                }
            }
            return '<h3>'.$aleatorio.' es multiplo de: '.$num.'</h3>';
            
    }else{
        return '<h3>No se encuentra el valor de $numero</h3>';
    }
}

function obtenerNumero2(){
    $encontrado = FALSE;
    if(isset($_GET['numero'])){
            $num = $_GET['numero'];
            do{
                $aleatorio = mt_rand();
                if($aleatorio % $num == 0){
                    $encontrado = TRUE;
                }
            }while(!$encontrado);

            return '<h3>'.$aleatorio.' es multiplo de: '.$num.'</h3>';
            
    }else{
        return '<h3>No se encuentra el valor de $numero</h3>';
    }
}

// |========================= EJERCICIO 4 =========================|
function abecedario(){
    $arreglo = array();

    for($n = 97; $n<=122; $n++){        
        $arreglo[$n] = chr($n);
    }
    // Crear tabla en XHTML
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Índice</th><th>Valor</th></tr>";

    foreach($arreglo as $key => $value){
        echo "<tr>";
        echo "<td>$key</td><td>$value</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// |========================= EJERCICIO 5 =========================|
function mostrarDatos($nombre, $correo){
    return "<h3>Nombre: $nombre</h3><h3>Correo: $correo</h3>";
}

function validarEdadSexo($edad, $sexo){
    if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
        return "<h3>Bienvenido, usted está en el rango de edad permitido.</h3>";
    } else {
        return "<h3>Error: Vállase</h3>";
    }
}
// |========================= EJERCICIO 6 =========================|

function getParqueVehicular() {
    return array(
        "ABC1234" => array(
            "Auto" => array(
                "marca" => "HONDA",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Alfonso Esparza",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            )
        ),
        "XYZ5678" => array(
            "Auto" => array(
                "marca" => "MAZDA",
                "modelo" => 2019,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Consuelo Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 Oriente"
            )
        ),
    "DCB1305" => array(
        "Auto" => array(
            "marca" => "TOYOTA",
            "modelo" => 2021,
            "tipo" => "Pick-Up"
        ),
        "Propietario" => array(
            "nombre" => "David Carcamo",
            "ciudad" => "CDMX",
            "direccion" => "Av. Reforma 120"
        )
        ),
        "VVH15043" => array(
            "Auto" => array(
                "marca" => "NISSAN",
                "modelo" => 2018,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Valeria Vazquez",
                "ciudad" => "Guadalajara, Jal.",
                "direccion" => "Col. Americana"
            )
        ),
        "RTY3456" => array(
            "Auto" => array(
                "marca" => "CHEVROLET",
                "modelo" => 2017,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Luis Herrera",
                "ciudad" => "Monterrey, NL",
                "direccion" => "Av. Constitución"
            )
        ),
        "UIO2345" => array(
            "Auto" => array(
                "marca" => "FORD",
                "modelo" => 2022,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Ana López",
                "ciudad" => "Querétaro, Qro.",
                "direccion" => "Centro Histórico"
            )
        ),
        "PAS6789" => array(
            "Auto" => array(
                "marca" => "KIA",
                "modelo" => 2021,
                "tipo" => "hachback"
            ),
            "Propietario" => array(
                "nombre" => "Carlos Ramírez",
                "ciudad" => "León, Gto.",
                "direccion" => "Blvd. López Mateos"
            )
        ),
        "MNB1122" => array(
            "Auto" => array(
                "marca" => "VOLKSWAGEN",
                "modelo" => 2016,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Fernanda Díaz",
                "ciudad" => "Toluca, Edo. Mex.",
                "direccion" => "Col. Centro"
            )
        ),
        "JKL9988" => array(
            "Auto" => array(
                "marca" => "HYUNDAI",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Ricardo Pérez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "San Manuel"
            )
        ),
        "VBN5566" => array(
            "Auto" => array(
                "marca" => "PEUGEOT",
                "modelo" => 2019,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Gabriela Torres",
                "ciudad" => "CDMX",
                "direccion" => "Roma Norte"
            )
        ),
        "ASD4455" => array(
            "Auto" => array(
                "marca" => "BMW",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Santiago Mejía",
                "ciudad" => "San Luis Potosí, SLP",
                "direccion" => "Col. Universitaria"
            )
        ),
        "FGH7788" => array(
            "Auto" => array(
                "marca" => "MERCEDES",
                "modelo" => 2021,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Daniel Castro",
                "ciudad" => "Querétaro, Qro.",
                "direccion" => "El Campanario"
            )
        ),
        "ZXC3344" => array(
            "Auto" => array(
                "marca" => "AUDI",
                "modelo" => 2020,
                "tipo" => "hachback"
            ),
            "Propietario" => array(
                "nombre" => "Patricia Ruiz",
                "ciudad" => "Guadalajara, Jal.",
                "direccion" => "Av. Chapultepec"
            )
        ),
        "BNM2211" => array(
            "Auto" => array(
                "marca" => "TESLA",
                "modelo" => 2023,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Miguel Ángel",
                "ciudad" => "Monterrey, NL",
                "direccion" => "Valle Oriente"
            )
        ),
        "HJK8899" => array(
            "Auto" => array(
                "marca" => "FIAT",
                "modelo" => 2018,
                "tipo" => "hachback"
            ),
            "Propietario" => array(
                "nombre" => "Laura Sánchez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Av. Juárez"
            )
        )
    );
}

function buscarAutoPorMatricula($matricula) {
    $parque = getParqueVehicular();
    $matricula = strtoupper($matricula);
    if (isset($parque[$matricula])) {
        return $parque[$matricula];
    }
    return null;
}

function mostrarTodosAutos() {
    return getParqueVehicular();
}

?>

