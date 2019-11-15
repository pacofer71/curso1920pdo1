<!DOCTYPE html>
<?php
session_start();
//hacemos el autoload de las clases
spl_autoload_register(function ($nombre) {
    require "./class/" . $nombre . ".php";
});
$conexion=new Conexion();
$llave=$conexion->getConector();

$modulo=new Modulos($llave);
$misModulos=$modulo->read();

?>
<html lang="es">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style='background-color:salmon'>
    <h3 class='text-center mt-4'>Crud Modulos</h3>
    <div class="container mt-3">
        <a href="cmodulo.php" class='btn btn-success mb-3'>Nuevo Modulo</a>
        <?php
            if(isset($_SESSION['mensaje'])){
                echo "<p class='mt-3 mb-3 text-primary'>{$_SESSION['mensaje']}</p>";
                unset($_SESSION['mensaje']);
            } 
        ?>
        <table class="table table-striped table-dark">
            <thead>
                <tr style='text-align:center; font-weight:bold;'>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Horas</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($misModulos as $mod){
                        echo "<tr style='text-align:center'>".PHP_EOL;
                        echo "<th scope='row'>{$mod->idMod}</th>";
                        echo "<td>{$mod->nomMod}</td>";
                        echo "<td>{$mod->horasSem}</td>";
                        echo "<td>#</td>";
                        echo "</tr>";
                    }
                    $llave=null;
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>