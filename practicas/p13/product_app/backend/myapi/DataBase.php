<?php
namespace TECWEB\MYAPI;

abstract class DataBase {
    protected $conexion;
    protected $data; // Agregado según UML (protected #data)

    public function __construct($db, $user, $pass) {
        $this->data = array(); // Inicializamos data
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );
    
        if(!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
    }

    // Método movido aquí según el diagrama UML para que lo hereden las otras clases
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>