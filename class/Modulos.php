<?php
class Modulos{
    private $idMod;
    private $nomMod;
    private $horasSem;
    private $conector;

    public function __construct(){
        $num=func_num_args();
        if($num==1){
            $this->conector=func_get_arg(0);
        }
        if($num==3){
            $this->conector=func_get_arg(0);
            $this->nomMod=func_get_arg(1);
            $this->horasSem=func_get_arg(2);
        }

    }
    //-----------------------------CRUD
    //Create-----------
    public function create(){
        $create="insert into modulos(nomMod, horasSem) values(:n, :h)";
        $stmt=$this->conector->prepare($create);
        try{
            $stmt->execute([
                ':n'=>$this->nomMod,
                ':h'=>$this->horasSem
            ]);
        }catch(PDOException $ex){
            die("Error al crear el Módulo!!! ". $ex);
        }

    }
    //Read-----------------
    public function read(){
        $consulta="select * from modulos order by nomMod";
        $stmt=$this->conector->prepare($consulta);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los modulos ". $ex);
        }
        $modulos=$stmt->fetchAll(PDO::FETCH_OBJ);
        return $modulos;
    }
    //Update--------------------------
    public function update(){

    }
    //Delete----------------------
    public function delete(){

    }
    //-----------------getters y setter
    public function setIdMod($id){
        $this->idMod=$id;
    }
    public function setNomMod($n){
        $this->nomMod=$n;
    }
    public function setHorasSem($h){
        $this->horasSem=$h;
    }
}