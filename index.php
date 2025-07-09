<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "35.238.38.29"; 
$user = "root"; 
$password = "123456"; 
$database = "practica";

$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Nueva consulta adaptada a tu BD y estructura
$consulta = "
    SELECT 
        p.nombres,
        p.apellidos,
        p.correo,
        p.fecha_nacimiento,
        e.descripcion AS enfermedad,
        e.gravedad,
        p.telefonos
    FROM Pacientes p
    JOIN Enfermedades e ON p.id_enfermedades = e.id_enfermedades
";

$resultado = mysqli_query($conexion, $consulta);

// Función para calcular edad desde fecha de nacimiento
function calcularEdad($fecha_nacimiento) {
    $fecha = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha);
    return $edad->y;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pacientes y Enfermedades</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    crossorigin="anonymous">
</head>
<body>
  <div class="container mt-5">
    <h1 class="display-4 text-center">Lista de Pacientes y sus Enfermedades</h1>
    <hr>

    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0) {
      echo "
      <table class='table table-bordered table-striped mt-4'>
        <thead class='thead-dark'>
          <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Edad</th>
            <th>Enfermedad</th>
            <th>Gravedad</th>
            <th>Teléfonos</th>
          </tr>
        </thead>
        <tbody>";

      while ($fila = mysqli_fetch_assoc($resultado)) {
        $edad = calcularEdad($fila['fecha_nacimiento']);
        echo "
          <tr>
            <td>{$fila['nombres']}</td>
            <td>{$fila['apellidos']}</td>
            <td>{$fila['correo']}</td>
            <td>{$edad}</td>
            <td>{$fila['enfermedad']}</td>
            <td>{$fila['gravedad']}</td>
            <td>{$fila['telefonos']}</td>
          </tr>";
      }

      echo "</tbody></table>";
    } else {
      echo "<p class='text-danger text-center'>No se encontraron registros de pacientes.</p>";
    }
    ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    crossorigin="anonymous"></script>
</body>
</html>
