<?php
namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Read extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($db, $user, $pass);
    }

    public function list() {
        $this->data = array();
        
        if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function search($search) {
        $this->data = array();
        
        if( isset($search) ) {
            $search = $this->conexion->real_escape_string($search);
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
            
            if ( $result = $this->conexion->query($sql) ) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if(!is_null($rows)) {
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function single($id) {
        $this->data = array();
        
        if( isset($id) ) {
            $id = intval($id);
            
            if ( $result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}") ) {
                $row = $result->fetch_assoc();
    
                if(!is_null($row)) {
                    foreach($row as $key => $value) {
                        $this->data[$key] = $value;
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function checkName($nombre) {
        $this->data = array('exists' => false);
        
        if(isset($nombre) && !empty(trim($nombre))) {
            $nombre_escapado = $this->conexion->real_escape_string(trim($nombre));
            
            $sql = "SELECT id FROM productos WHERE nombre = '{$nombre_escapado}' AND eliminado = 0 LIMIT 1";
            
            if ($result = $this->conexion->query($sql)) {
                if ($result->num_rows > 0) {
                    $this->data['exists'] = true;
                    $row = $result->fetch_assoc();
                    $this->data['id'] = $row['id'];
                } else {
                    $this->data['exists'] = false;
                }
                $result->free();
            } else {
                $this->data['error'] = 'Error en la consulta: ' . mysqli_error($this->conexion);
            }
            
            $this->conexion->close();
        } else {
            $this->data['error'] = 'Nombre vacío o no válido';
        }
    }
}
?>