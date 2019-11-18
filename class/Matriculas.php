<?php
    class Matriculas{
        private $al;
        private $modulo;
        private $notaFinal;
        private $conector;

        public function __construct()
        {
            $n=func_num_args();
            
            if($n==1){
                $this->conector=func_get_arg(0);
            }session_start();
            //hacemos el autoload de las clases
            spl_autoload_register(function ($nombre) {
                require "./class/" . $nombre . ".php";
            });
            $conexion=new Conexion();
            $llave=$conexion->getConector();
            
            }    
        }
        ///////////////CRUD
        public function create(){

        }
        public function read(){
            $cons="select al, modulo, nomAl, apeAl, nomMod, notaFinal from alumnos, modulos, matriculas where idAl=al AND modulo=idMod order by apeAl, nomMod";
            $stmt=$this->conector->prepare($cons);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al recuperar matriculas!!! ".$ex);
            }
            $todos=$stmt->fetchAll(PDO::FETCH_OBJ);
            
            return $todos;
        }
        public function update(){

        }
        public function delete(){
            $delete="delete from matriculas where al=:a AND modulo=:m";
            $stmt=$this->conector->prepare($delete);
            try{
                $stmt->execute([
                    ':a'=>$this->al,
                    ':m'=>$this->modulo
                ]);
            }catch(Exception $ex){
                die("Error al dar de baja el alaumno en el modulo!!");
            }
        }        
        //----------------------getters setters y otros metodos
        public function setAl($a){
            $this->al=$a;
        }
        public function setModulo($n){
            $this->modulo=$n;
        }
        public function setNotaFinal($n){
            $this->notaFinal=$n;
        }

}