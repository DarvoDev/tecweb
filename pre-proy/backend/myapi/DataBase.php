<?php
namespace MyApi;

abstract class DataBase
{
    protected $conexion;

    public function __construct($db, $user, $pass)
    {
        $this->conexion = @mysqli_connect(
            'localhost',    
            $user,
            $pass,
            $db
        );

        if (!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }

        $this->conexion->set_charset("utf8");
    }
}