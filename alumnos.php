<!DOCTYPE html>
<?php
    session_start();
    //hacemos el autoload de las clases
    spl_autoload_register(function($nombre){
        require "./class/".$nombre.".php";
    });
    $conexion=new Conexion();
    $miLlave=$conexion->getConector();
    $alumnos=new Alumnos($miLlave);
    $todoslosAlumnos=$alumnos->read();
?>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body style='background-color:salmon'>
    <h3 class='text-center mt-4'>Crud Alumnos</h3>
    <div class="container mt-3">
    <?php
            if(isset($_SESSION['mensaje'])){
                echo "<p class='mt-3 mb-3 text-success'>";
                echo $_SESSION['mensaje'];
                echo "</p>";
                unset($_SESSION['mensaje']);
            }
        ?>
      <a href="calumno.php" class='btn btn-success mb-3'>Nuevo Alumno</a>
    <table class="table table-striped table-dark">
  <thead>

    <tr>
      <th scope="col">Codigo</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Nombre</th>
      <th scope="col">Mail</th>
      <th scope='col'>Creado</th>
      <th scope='col'>Acciones</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach($todoslosAlumnos as $alumno){
        echo "<tr>";
        echo "<th scope='row'>{$alumno->idAl}</th>";
        echo "<td>{$alumno->apeAl}</td>";
        echo "<td>{$alumno->nomAl}</td>";
        echo "<td>{$alumno->mail}</td>";
        echo "<td>{$alumno->created_at}</td>";
        echo "<td>";
        echo "<form name='as' action='balumno.php' method='post' style='display:inline'>";
        echo "<input type='hidden' name='id' value='{$alumno->idAl}' >";
        echo "<a href='ealumno.php?id={$alumno->idAl}' class='btn btn-info'>Editar</a>&nbsp;";
        echo "<input type='submit' value='Borrar' class='btn btn-danger' >";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
   ?>
  </tbody>
</table>
    </div>

    </body>
</html>