<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Datos Personales de Paciente</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="jumbotron mt-4">
      <h1 class="display-4">
        <?php 
          if (isset($_GET['id_paciente'])) {
            // Conexión a la base de datos
            $conexion = mysqli_connect(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), "practica");
            if ($conexion) {
              $id_paciente = $_GET['id_paciente'];
              $cadenaSQL = "SELECT nombres FROM Pacientes WHERE id_paciente = $id_paciente";
              $resultado = mysqli_query($conexion, $cadenaSQL);
              if ($resultado && mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                echo "Datos personales de " . $fila['nombres'];
              }
              mysqli_close($conexion);
            } else {
              echo "Error en la conexión";
            }
          } else {
            echo "Seleccione un paciente";
          }
        ?>
      </h1>
      <p class="lead">Aplicación para visualizar los detalles de los pacientes</p>
      <hr class="my-4">
      <p>Conexión PHP con MySQL</p>
    </div>

    <?php
    if (isset($_GET['id_paciente'])) {
      // Mostrar los datos del paciente seleccionado
      $conexion = mysqli_connect(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), "practica");

      if ($conexion) {
        $id_paciente = $_GET['id_paciente'];
        $cadenaSQL = "
          SELECT 
            p.nombres, p.apellidos, p.correo, p.fecha_nacimiento, p.telefonos,
            e.descripcion AS enfermedad, e.gravedad
          FROM 
            Pacientes p
          JOIN 
            Enfermedades e ON p.id_enfermedades = e.id_enfermedades
          WHERE 
            p.id_paciente = $id_paciente
        ";

        $resultado = mysqli_query($conexion, $cadenaSQL);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
          $fila = mysqli_fetch_assoc($resultado);
          echo "<table class='table table-bordered'>
                  <tr><th>Nombre</th><td>" . $fila['nombres'] . "</td></tr>
                  <tr><th>Apellidos</th><td>" . $fila['apellidos'] . "</td></tr>
                  <tr><th>Correo</th><td>" . $fila['correo'] . "</td></tr>
                  <tr><th>Fecha de Nacimiento</th><td>" . $fila['fecha_nacimiento'] . "</td></tr>
                  <tr><th>Teléfonos</th><td>" . $fila['telefonos'] . "</td></tr>
                  <tr><th>Enfermedad</th><td>" . $fila['enfermedad'] . "</td></tr>
                  <tr><th>Gravedad</th><td>" . $fila['gravedad'] . "</td></tr>
                </table>";
        } else {
          echo "<p>No se encontraron datos para este paciente.</p>";
        }
        mysqli_close($conexion);
      } else {
        echo "<p>Hubo un error al conectar con la base de datos.</p>";
      }
    } else {
      // Mostrar lista de pacientes con enlaces para ver detalles
      $conexion = mysqli_connect(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), "practica");

      if ($conexion) {
        $cadenaSQL = "SELECT id_paciente, nombres FROM Pacientes";
        $resultado = mysqli_query($conexion, $cadenaSQL);
        echo "<h3>Lista de Pacientes</h3><ul class='list-group'>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
          echo "<li class='list-group-item'><a href='?id_paciente=" . $fila['id_paciente'] . "'>" . $fila['nombres'] . "</a></li>";
        }
        echo "</ul>";
        mysqli_close($conexion);
      } else {
        echo "<p>Hubo un error al conectar con la base de datos.</p>";
      }
    }
    ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
          integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
          crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" 
          crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
          integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" 
          crossorigin="anonymous"></script>
</body>
</html>


