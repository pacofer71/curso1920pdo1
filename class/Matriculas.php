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
            }
            //hacemos el autoload de las clases
            spl_autoload_register(function ($nombre) {
                require "./class/" . $nombre . ".php";
            });
            $conexion=new Conexion();
            $llave=$conexion->getConector();
            
            }    
        
        ///////////////CRUD
        public function create(){
            $c="insert into matriculas values(:a, :m, :n)";
            $stmt=$this->conector->prepare($c);
            try{
                $stmt->execute([
                    ':a'=>$this->al,
                    ':m'=>$this->modulo,
                    ':n'=>$this->notaFinal
                ]);
            }catch(Exception $ex){
                die("Error al matricular Alumno!!". $ex);
            }
        }
        public function read($p, $c){
            $cons="select al, modulo, nomAl, apeAl, nomMod, notaFinal from alumnos, modulos, matriculas where idAl=al AND modulo=idMod order by apeAl, nomMod limit $p, $c";
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
            $u="update matriculas set notaFinal=:n where al=:a AND modulo=:m";
            $stmt=$this->conector->prepare($u);
            try{
                $stmt->execute([
                    ':a'=>$this->al,
                    ':m'=>$this->modulo,
                    ':n'=>$this->notaFinal
                ]);
            }catch(Exception $ex){
                die("Error al matricular Alumno!!". $ex);
            }

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
        public function existeMatricula($a, $m){
                $consulta="select * from matriculas where al=:a AND modulo=:m";
                $stmt=$this->conector->prepare($consulta);
                try{
                    $stmt->execute([
                        ':a'=>$a,
                        ':m'=>$m
                    ]);
                }catch(PDOException $ex){
                    die("Error al comprobar mat ". $ex);
                }
                $cont=0;
                while($fila=$stmt->fetch()){
                    $cont++;
                }
                return ($cont!=0);
        }

        //----------------------
        public function getMatricula($a, $m){
            $cons="select al, modulo, nomAl, apeAl, nomMod, notaFinal from alumnos, modulos, matriculas where idAl=al AND modulo=idMod AND al=:a AND modulo=:m";
            $stmt=$this->conector->prepare($cons);
            try{
                $stmt->execute([
                    ':a'=>$a,
                    ':m'=>$m
                ]);
            }catch(PDOException $ex){
                die("Error al devolver Matricula ". $ex);
            }
            $fila=$stmt->fetch(PDO::FETCH_OBJ);
            return $fila;

        }
        //-------------------------------------------
        public function setAl($a){
            $this->al=$a;
        }
        public function setModulo($n){
            $this->modulo=$n;
        }
        public function setNotaFinal($n){
            $this->notaFinal=$n;
        }
        //----------Total de registros para paginacion;
        public function getTotal(){
            $c="select * from matriculas";
            $stmt=$this->conector->prepare($c);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al contar registros!! ". $ex);
            }
            $cont=0;
            while($fila=$stmt->fetch()){
                $cont++;
            }
            return $cont;
        }

}