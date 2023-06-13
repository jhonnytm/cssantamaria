<?php
class Modelo{
    private $Modelo;
    private $db;
    private $tablita;
    public function __construct(){
        $this->Modelo = array();
        $this->db = new PDO('mysql:host=192.168.100.100; dbname=cssantamaria','root','');

    }
    public function insertar($tabla, $data){
        $consulta = "INSERT INTO" . $tabla . "VALUES(null," . $data .")";
        $resultado=$this->db->query($consulta);
        if($resultado){
            return true;
        }else{
            return false;
        }
    }

    public function mostrar($tabla, $condicion){
        $consult = "SELECT * FROM " . $tabla . " WHERE " . $condicion . ";";
        $result = $this->db->query($consult);
        while($filas = $result->FETCHALL(PDO::FETCH_ASSOC)){
            $this->tablita[]=$filas;
        }
        return $this->tablita;
    }

    public function actualizar($tabla, $data, $condicion){
        $consul ="UPDATE " . $tabla. " SET " . $data ." WHERE " . $condicion ;
        $resul = $this->db->query($consul);
        if($resultado){
            return true;
        }else{
            return false;
        }
    }
    public function eliminar($data, $condicion){
        $elimina = "DELETE FROM ". $tabla . " WHERE " . $condicion;
        $resu = $this->db->query($elimina);
        if($resu){
            return true;
        }else{
            return false;
        }
    }


}

?>