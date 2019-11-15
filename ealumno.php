<!DOCTYPE html>
<?php
if(!isset($_GET['id'])){
    header('Location:alumnos.php');
    die();
}
session_start();

//hacemos el autoload de las clases
spl_autoload_register(function ($nombre) {
    require "./class/" . $nombre . ".php";
});
$conexion=new Conexion();
$miLlave=$conexion->getConector();
$alumno=new Alumnos($miLlave);
$alumno->setIdAl($_GET['id']);
$datosAlumno=$alumno->getAlumno();
function error($txt){
    $_SESSION['error']=$txt;
    $id=$_GET['id'];
    header("Location:ealumno.php?id=$id");
    die();
}
function editarAlumno($n, $a, $m){
        global $alumno;
        global $datosAlumno;
        $alumno->setNomAl($n);
        $alumno->setApeAl($a);
        $alumno->setMail($m);
        //compruebo si he modificado o no el mail por el tema de no permitir
        //mails únicos
        if($m!=$datosAlumno->mail){
            //si ha cambiado el mail compruebo que no exista
            //el mail nuevo
            if($alumno->existeMail()){
                error("El mail está duplicado, elije otro.");
            }
        }
        $alumno->edit();
        $_SESSION['mensaje']="Alumno Modificado con exito.";
        header('Location:alumnos.php');


}


?>
<html lang="es">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style='background-color:salmon'>
    <h3 class='text-center mt-4'>Editar Alumno</h3>
    <div class="container mt-3">
        <?php
            if(isset($_POST['enviar'])){
                //procesamos
                $nombre=ucwords(trim($_POST['nombre']));
                $ape=ucwords(trim($_POST['ape']));
                $mail=trim($_POST['email']);
                if(strlen($nombre)==0 || strlen($ape)==0){
                    error("Error Los campos deben conterner algún caracter");
                }
                editarAlumno($nombre, $ape, $mail);
            }
            else{ 
        ?>
        <?php
            if(isset($_SESSION['error'])){
                echo "<p class='mt-3 mb-3 text-danger'>";
                echo $_SESSION['error'];
                echo "</p>";
                unset($_SESSION['error']);
            }
        ?>
        <form name='as' action='<?php echo $_SERVER['PHP_SELF']."?id={$datosAlumno->idAl}"; ?>' method='POST' >
            <div class="form-group">
                <label for="nom">Nombre</label>
                <input type="text" class="form-control" id="nom" value='<?php echo $datosAlumno->nomAl; ?>' name='nombre' required>

            </div>
            <div class="form-group">
                <label for="ape">Apellidos</label>
                <input type="text" class="form-control" id="ape" value='<?php echo $datosAlumno->apeAl; ?>' name='ape' required >
            </div>
            <div class="form-group">
                <label for="mail">E-Mail</label>
                <input type="email" class="form-control" id="mail" value='<?php echo $datosAlumno->mail; ?>' name='email' required >
            </div>
            <input type='submit' class='btn btn-primary' name='enviar' value='Modificar'>&nbsp;
           
            <a href='alumnos.php' class='btn btn-info'>Volver</a>
            
        </form>
    </div>
            <?php } ?>
</body>

</html>