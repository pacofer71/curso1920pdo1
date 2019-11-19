<!DOCTYPE html>
<?php
session_start();
spl_autoload_register(function ($nombre) {
    require './class/' . $nombre . '.php';
});

$conexion=new Conexion();
$llave=$conexion->getConector();
$alumno=new Alumnos($llave);
$modulo=new Modulos($llave);
$matricula=new Matriculas($llave);
$todosAl=$alumno->read();
$todosMod=$modulo->read();


function error($mes)
{
    $_SESSION['error'] = $mes;
    header('Location:cmatricula.php');
    die();
}
function matricular($a, $m, $n){
    global $matricula;
    $matricula->setAl($a);
    $matricula->setModulo($m);
    $matricula->setNotaFinal($n);
    $matricula->create();
    $llave=null;
    $_SESSION['mensaje']="Matricula realizada correctamente.";
    header('Location:matriculas.php');
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
    <h3 class='mt-3 text-center'>Matricular Alumno</h3>
    <div class="container mt-3">
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='text-danger mb-2'>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
        if (isset($_POST['enviar'])) {
            //Procesamos
           $al=$_POST['al'];
           $mod=$_POST['mod'];
           $nota=$_POST['nota'];
            if ($matricula->existeMatricula($al, $mod)) {
                error("El alumno ya está Matriculado de ese Módulo!!!");
                $llave=null;
            }
            matricular($al, $mod, $nota);
        } else {
            ?>
            <form name='as' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
                <div class="row">
                    <div class="col">
                        <select class="form-control form-control-lg" name='al'>
                           <?php
                                foreach($todosAl as $item){
                                    echo "<option value='{$item->idAl}'>{$item->apeAl}, {$item->nomAl}</option>";
                                }

                           ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <select class="form-control form-control-lg" name='mod'>
                           <?php
                                foreach($todosMod as $item){
                                    echo "<option value='{$item->idMod}'>{$item->nomMod}  ({$item->horasSem})</option>";
                                } 
                           ?>
                        </select>
                    </div>
                    <div class="col">
                    <input type='number' class='form-control-lg' name='nota' max='10' min='0' required value='0'>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name='enviar'>Crear</button>&nbsp;
                <input type='reset' value='Limpiar' class='btn btn-warning'>&nbsp;
                <a href='matriculas.php' class='btn btn-info'>Volver</a>

            </form>

    </div>

<?php } ?>
</body>

</html>