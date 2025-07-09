<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Datos Personales de Paciente</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <style>
    .titulo {
      color: red;
    }
    .container {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php 
      // Conexión a la base de datos
      $conexion = mysqli_connect("35.238.38.29", "karen", "123456", "practica");
      if (!$conexion) {
        echo "<p>Hubo un error al conectar con la base de datos.</p>";
      } else {
        if (isset($_GET['id_paciente'])) {
          // Mostrar los datos del paciente seleccionado
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
            echo "<h2 class='titulo'>Datos personales de " . $fila['nombres'] . "</h2>";
            echo "<table class='table table-bordered mt-3'>
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
        } else {
          // Mostrar lista de pacientes con enlaces para ver detalles
          $cadenaSQL = "SELECT id_paciente, nombres FROM Pacientes";
          $resultado = mysqli_query($conexion, $cadenaSQL);
          echo "<h3>Lista de Pacientes</h3><ul class='list-group'>";
          while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<li class='list-group-item'><a href='?id_paciente=" . $fila['id_paciente'] . "'>" . $fila['nombres'] . "</a></li>";
          }
          echo "</ul>";
        }

        // Mostrar los pacientes cuyo nombre no empieza con una vocal
        $cadenaSQL = "
          SELECT id_paciente, nombres
          FROM Pacientes
          WHERE LEFT(nombres, 1) NOT IN ('A', 'E', 'I', 'O', 'U')
        ";
        $resultado = mysqli_query($conexion, $cadenaSQL);
        if (mysqli_num_rows($resultado) > 0) {
          echo "<h3 class='mt-4'>Pacientes cuyo nombre no empieza con una vocal</h3>";
          echo "<table class='table table-bordered'>
                  <thead>
                    <tr><th>ID Paciente</th><th>Nombre</th></tr>
                  </thead>
                  <tbody>";
          while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr><td>" . $fila['id_paciente'] . "</td><td>" . $fila['nombres'] . "</td></tr>";
          }
          echo "</tbody></table>";
        } else {
          echo "<p>No hay pacientes cuyo nombre no empiece con una vocal.</p>";
        }

        // Cerrar conexión
        mysqli_close($conexion);
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

