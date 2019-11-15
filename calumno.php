<!DOCTYPE html>
<?php
session_start();
//hacemos el autoload de las clases
spl_autoload_register(function ($nombre) {
    require "./class/" . $nombre . ".php";
});
function error($txt){
    $_SESSION['error']=$txt;
    header('Location:calumno.php');
    die();
}

function crearAlumno($n, $a, $m){
    $conexion = new Conexion();
    $miLlave = $conexion->getConector();
    $alumno=new Alumnos($miLlave, $n, $a, $m);
    if($alumno->existeMail()){
        error("Ese mail ya está registrado!!!!");
    }
    $alumno->create();
    $_SESSION['mensaje']='Alumno crado correctamente';
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
    <h3 class='text-center mt-4'>Crear Alumno</h3>
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
                crearAlumno($nombre, $ape, $mail);
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
        <form name='as' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' >
            <div class="form-group">
                <label for="nom">Nombre</label>
                <input type="text" class="form-control" id="nom" placeholder="Nombre" name='nombre' required>

            </div>
            <div class="form-group">
                <label for="ape">Apellidos</label>
                <input type="text" class="form-control" id="ape" placeholder="Apellidos" name='ape' required >
            </div>
            <div class="form-group">
                <label for="mail">E-Mail</label>
                <input type="email" class="form-control" id="mail" placeholder="E-mail" name='email' required >
            </div>
            <input type='submit' class='btn btn-primary' name='enviar' value='Crear'>&nbsp;
            <input type='reset' class='btn btn-warning' value='Limpiar' >&nbsp;
            <a href='alumnos.php' class='btn btn-info'>Volver</a>
            
        </form>
    </div>
            <?php } ?>
</body>

</html>