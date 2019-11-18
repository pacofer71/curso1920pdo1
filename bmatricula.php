<?php
if(!isset($_POST['al']) || !isset($_POST['mod'])){
    header('Location:matriculas.php');
    die();
}
session_start();
//hacemos el autoload de las clases
spl_autoload_register(function ($nombre) {
    require "./class/" . $nombre . ".php";
});
$conexion=new Conexion();
$llave=$conexion->getConector();
$al=$_POST['al'];
$mod=$_POST['mod'];
$matricula=new Matriculas($llave);
$matricula->setAl($al);
$matricula->setModulo($mod);
$matricula->delete();
$_SESSION['mensaje']="Se ha dado de baja al Alumno del Módulo correctamente";
header('Location:matriculas.php');
