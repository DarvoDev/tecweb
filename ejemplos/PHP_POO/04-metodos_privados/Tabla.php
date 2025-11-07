<?php
class Tabla{
    private $matriz = array();
    private $numFilas;
    private $estilo;
    private $numColumnas;

    public function __construct($rows, $cols, $style){
        $this->numFilas = $rows;
        $this->numColumnas;
        $this->estilo = $style;

    }

    public function cargar($row, $col, $val){
        $this->matriz[$row][$col] = $val;
    }

    private function inicio_tabla(){
        echo '<table style="'.$this->estilo.'">';
    }

    private function inicio_fila(){
        echo '<tr>';
    }

    private function mostrar_dato($row, $col){
        echo '<td style ="'.$this->estilo.'">'.$this->matriz[$row][$col].'</td>';
    }


    private function fin_fila(){
        echo '</tr>';
    }

    private function fin_table(){
        echo '</table>';
    }

    private function graficar(){
        $this->inicio_tabla();
        $this->fin_table();
    }



}
?>