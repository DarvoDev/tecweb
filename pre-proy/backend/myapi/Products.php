<?php
namespace MyApi;

require_once __DIR__.'/DataBase.php';

class Products extends DataBase
{
    private $data = array(); 
    public function __construct($db, $user = 'root', $pass = '') 
    {
        // Llama al constructor de la SuperClase para inicializar la conexion
        parent::__construct($db, $user, $pass);
        $this->data = array();
    }

    public function add($productObj)
    {
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        
        $sql = "SELECT * FROM productos WHERE nombre = '{$productObj->nombre}' AND eliminado = 0";
        $result = $this->conexion->query($sql);

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO productos VALUES (null, '{$productObj->nombre}', '{$productObj->marca}', '{$productObj->modelo}', {$productObj->precio}, '{$productObj->detalles}', {$productObj->unidades}, '{$productObj->imagen}', 0)";
            
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó la consulta. " . mysqli_error($this->conexion);
            }
        }
        $result->free();
    }

    public function delete($id) 
    {
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";

        if ($this->conexion->query($sql)) {
            $this->data['status'] = "success";
            $this->data['message'] = "Producto eliminado";
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta. " . mysqli_error($this->conexion);
        }
    }
    
    public function edit($productObj) 
    {
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        

        $sql =  "UPDATE productos SET nombre='{$productObj->nombre}', marca='{$productObj->marca}',";
        $sql .= "modelo='{$productObj->modelo}', precio={$productObj->precio}, detalles='{$productObj->detalles}',"; 
        $sql .= "unidades={$productObj->unidades}, imagen='{$productObj->imagen}' WHERE id={$productObj->id}";
        
        if ($this->conexion->query($sql)) {
            $this->data['status'] = "success";
            $this->data['message'] = "Producto actualizado";
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta. " . mysqli_error($this->conexion);
        }
    }
    public function list() // +list(): void
    {
        $sql = "SELECT * FROM productos WHERE eliminado = 0";

        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function search($search)
    {
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function single($id)
    {
        $sql = "SELECT * FROM productos WHERE id = {$id}";

        if ($result = $this->conexion->query($sql)) {
            $row = $result->fetch_assoc();

            if (!is_null($row)) {
                foreach ($row as $key => $value) {
                    $this->data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function singleByName($nombre) 
    {
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        
        if ($result = $this->conexion->query($sql)) {
            $row = $result->fetch_assoc();

            if (!is_null($row)) {
                foreach ($row as $key => $value) {
                    $this->data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function validateName($nombre)
    {
        $this->data = array('exists' => false);
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        $result = $this->conexion->query($sql);
        
        if ($result->num_rows > 0) {
            $this->data['exists'] = true;
        }

        $result->free();
    }

    public function getData() 
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
    
    public function __destruct() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}