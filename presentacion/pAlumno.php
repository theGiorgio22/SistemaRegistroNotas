<?php
include_once "../negocio/nAlumno.php";

$alumno = null;
$alumnoObj = null;

// Conexión general para la tabla
$conexion = new dconexion();
$con = $conexion->Conectar();
$listado = mysqli_query($con, "SELECT * FROM alumno");

// Operaciones del CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod = isset($_POST['codigo']) ? $_POST['codigo'] : 0;
    $nom = $_POST['nombre'];
    $ape = $_POST['apellido'];
    $dir = $_POST['direccion'];
    $tel = $_POST['telefono'];

    $alumnoObj = new nAlumno($cod, $nom, $ape, $dir, $tel);

    $accion = $_POST['accion'];

    if ($accion == 'insertar') {
        $alumnoObj->insertar();
    } elseif ($accion == 'modificar') {
        $alumnoObj->modificar();
    } elseif ($accion == 'eliminar') {
        $alumnoObj->eliminar();
    } elseif ($accion == 'buscar') {
        $alumno = $alumnoObj->buscar();
    }

    // Recargar listado después de acción
    $listado = mysqli_query($con, "SELECT * FROM alumno");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Repuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0fdf4;
        }
        .bg-green {
            background-color: #198754 !important; /* Bootstrap green */
        }
        .btn-green {
            background-color: #198754;
            color: white;
        }
        .btn-green:hover {
            background-color: #157347;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center text-success mb-4">FORMULARIO DE ALUMNOS</h2>

    <form method="post" class="p-4 border rounded shadow" style="background-color: #d1e7dd;">

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>ID (para buscar, modificar o eliminar)</label>
                <input type="number" name="codigo" class="form-control" value="<?php echo isset($alumno['codigo']) ? $alumno['codigo'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo isset($alumno['nombre']) ? $alumno['nombre'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control" value="<?php echo isset($alumno['apellido']) ? $alumno['apellido'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label>Direccion</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo isset($alumno['direccion']) ? $alumno['direccion'] : ''; ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label>telefono</label>
                <input type="text" step="0.01" name="telefono" class="form-control" value="<?php echo isset($alumno['telefono']) ? $alumno['telefono'] : ''; ?>">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" name="accion" value="insertar" class="btn btn-green">Insertar</button>
            <button type="submit" name="accion" value="modificar" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
            <button type="submit" name="accion" value="buscar" class="btn btn-info text-white">Buscar</button>
        </div>

    </form>

    <hr class="my-4">

    <h4 class="text-success">Lista de Alumnos</h4>

    <table class="table table-striped table-hover table-bordered shadow">
        <thead class="bg-green text-white">
            <tr>
                <th>Codigo Estudiante</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Direccion</th>
                <th>telefono</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($listado)) { ?>
            <tr>
                <td><?php echo $fila['codigo']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['direccion']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
