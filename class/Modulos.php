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
        $update="update modulos set nomMod=:n, horasSem=:h where idMod=:i";
        $stmt=$this->conector->prepare($update);
        try{
                $stmt->execute([
                    ':n'=>$this->nomMod, 
                    ':h'=>$this->horasSem,
                    'i'=>$this->idMod
                ]);
        }catch(PDOException $ex){
            die("Error al actualizar el módulo, ".$ex);
            
        }

    }
    //Delete----------------------
    public function delete(){
        $borrar="delete from modulos where idMod=:i";
        $stmt=$this->conector->prepare($borrar);
        try{
            $stmt->execute([
                ':i'=>$this->idMod
            ]);
        }catch(PDOException $ex){
            die("Error al borrar módulo: ".$ex);
        }
    }
    //-----------------------------------------------------
    public function getModulo($id){
        $consulta="select * from modulos where idMod=:i";
        $stmt=$this->conector->prepare($consulta);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al recuperar el módulo, ". $ex);
        }
        //devolvemos todos los datos del módulo en cuestion
        $modulo=$stmt->fetch(PDO::FETCH_OBJ);
        return $modulo;
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