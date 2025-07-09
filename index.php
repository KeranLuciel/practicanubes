<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Catalog</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Datos Generales de Karen</h1> <!-- Título con el nombre del paciente -->
      <p class="lead">Aplicación para visualizar el catálogo de pacientes</p>
      <hr class="my-4">
      <p>Aplicación simple de Conexión PHP con MySQL</p>
    </div>

    <!-- Tabla con todos los pacientes -->
    <h2>Lista de Pacientes</h2>
    <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo</th>
          <th>Fecha de Nacimiento</th>
          <th>Enfermedad</th>
          <th>Teléfonos</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Conectar a la base de datos
        $conexion = mysqli_connect("35.238.38.29", "karen", "123456", "practica", 3306);

        if (!$conexion) {
          die("Conexión fallida: " . mysqli_connect_error());
        }

        // Consultar todos los pacientes
        $cadenaSQL = "SELECT p.nombres, p.apellidos, p.correo, p.fecha_nacimiento, e.descripcion AS enfermedad, p.telefonos
                      FROM Pacientes p
                      JOIN Enfermedades e ON p.id_enfermedades = e.id_enfermedades";
        $resultado = mysqli_query($conexion, $cadenaSQL);

        while ($fila = mysqli_fetch_object($resultado)) {
          echo "<tr><td>" . $fila->nombres . 
               "</td><td>" . $fila->apellidos . 
               "</td><td>" . $fila->correo . 
               "</td><td>" . $fila->fecha_nacimiento . 
               "</td><td>" . $fila->enfermedad . 
               "</td><td>" . $fila->telefonos . 
               "</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Tabla con pacientes cuyo nombre no comienza con una vocal -->
    <h2>Pacientes cuyo nombre no comienza con una vocal</h2>
    <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th>Nombre</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Filtrar pacientes cuyo nombre no empieza con una vocal
        $cadenaSQL2 = "SELECT nombres FROM Pacientes 
                       WHERE nombres NOT REGEXP '^[aeiouAEIOU]'";
        $resultado2 = mysqli_query($conexion, $cadenaSQL2);

        while ($fila2 = mysqli_fetch_object($resultado2)) {
          echo "<tr><td>" . $fila2->nombres . "</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
