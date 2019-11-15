<?php
session_start();
//hacemos el autoload de las clases
spl_autoload_register(function($nombre){
    require "./class/".$nombre.".php";
});
$conex=new Conexion();
$llave=$conex->getConector();
$alumno=new Alumnos($llave);
$id=$_POST['id'];
$alumno->setIdAl($id);
$alumno->delete();
$_SESSION['mensaje']="Alumno borrado correctamente.";
header('Location:alumnos.php');