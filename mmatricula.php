<!DOCTYPE html>
<?php
if(!isset($_GET['al']) || !isset($_GET['mod'])){
    header('Location:matriculas.php');
}

session_start();
spl_autoload_register(function ($nombre) {
    require './class/' . $nombre . '.php';
});

$conexion=new Conexion();
$llave=$conexion->getConector();
$matricula=new Matriculas($llave);
$datos=$matricula->getMatricula($_GET['al'], $_GET['mod']);


function error($mes)
{
    $_SESSION['error'] = $mes;
    header('Location:cmatricula.php');
    die();
}
function modificar($a, $m, $n){
    global $matricula;
    $matricula->setAl($a);
    $matricula->setModulo($m);
    $matricula->setNotaFinal($n);
    $matricula->update();
    $llave=null;
    $_SESSION['mensaje']="Matricula modificada correctamente.";
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
    <h3 class='mt-3 text-center'>Modificar Matricula</h3>
    <div class="container mt-3">
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='text-danger mb-2'>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
        if (isset($_POST['enviar'])) {
            //Procesamos
           $al=$_GET['al'];
           $mod=$_GET['mod'];
           $nota=$_POST['nota'];
           modificar($al, $mod, $nota);
        } else {
            ?>
            <form name='as' action='<?php echo $_SERVER['PHP_SELF']."?al={$datos->al}&mod={$datos->modulo}"; ?>' method='POST'>
                <div class="row">
                    <div class="col">
                       <input type='text' name='al' value='<?php echo $datos->apeAl. ", ".$datos->nomAl; ?>' readonly class='form-control'>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <input type='text' name='mod' value='<?php echo $datos->nomMod ?>' class='form-control' readonly>
                    </div>
                    <div class="col">
                    <input type='number' class='form-control-lg' name='nota' max='10' min='0' required value='<?php echo $datos->notaFinal; ?>'>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name='enviar'>Modificar</button>&nbsp;
                <a href='matriculas.php' class='btn btn-info'>Volver</a>

            </form>

    </div>

<?php } ?>
</body>

</html>