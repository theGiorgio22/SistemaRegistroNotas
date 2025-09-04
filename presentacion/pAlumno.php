<?php
include_once "../negocio/nAlumno.php";

$mensaje = "";
$alumno = ['codigo'=>'','nombre'=>'','apellido'=>'','direccion'=>'','telefono'=>''];

$nAlumnoObj = new nAlumno();
$listado = null;

try {
    $listado = $nAlumnoObj->listar();
} catch (Exception $e) {
    $mensaje = "Error al cargar los alumnos: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod  = $_POST['codigo'] ?? 0;
    $nom  = $_POST['nombre'] ?? '';
    $ape  = $_POST['apellido'] ?? '';
    $dir  = $_POST['direccion'] ?? '';
    $tel  = $_POST['telefono'] ?? '';

    $nAlumno = new nAlumno($cod, $nom, $ape, $dir, $tel);

    if (isset($_POST['insertar'])) {
        $resultado = $nAlumno->insertar();
        if ($resultado === "ok") {
            $mensaje = "✅ Alumno registrado correctamente";
        } elseif ($resultado === "error_duplicado") {
            $mensaje = "⚠️ Ya existe un alumno con el código " . htmlspecialchars($cod);
        } elseif ($resultado === "error_campos") {
            $mensaje = "⚠️ Debes rellenar todos los campos para registrar";
        } else {
            $mensaje = "❌ Error al registrar: $resultado";
        }
    } elseif (isset($_POST['modificar'])) {
        $resultado = $nAlumno->modificar();
        if ($resultado === "ok") {
            $mensaje = "✏️ Alumno modificado correctamente";
        } elseif ($resultado === "error_campos") {
            $mensaje = "⚠️ Debes rellenar todos los campos para modificar";
        } else {
            $mensaje = "❌ No se encontró el alumno a modificar";
        }
    } elseif (isset($_POST['eliminar'])) {
        $resultado = $nAlumno->eliminar();
        if ($resultado === "ok") {
            $mensaje = "🗑️ Alumno eliminado correctamente";
        } elseif ($resultado === "error_campos") {
            $mensaje = "⚠️ Debes rellenar todos los campos para eliminar";
        } elseif ($resultado === "error_no_coincide") {
            $mensaje = "❌ Los datos ingresados no coinciden con los registrados en la BD";
        } else {
            $mensaje = "❌ No se encontró el alumno o error al eliminar";
        }
    } elseif (isset($_POST['buscar'])) {
        $resultado = $nAlumno->buscar();
        if ($resultado && is_array($resultado)) {
            $alumno = $resultado;
            $mensaje = "🔎 Alumno encontrado";
        } else {
            $mensaje = "⚠️ Alumno no encontrado";
        }
    }

    try {
        $listado = $nAlumnoObj->listar();
    } catch (Exception $e) {
        $mensaje = "Error al actualizar lista: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Alumnos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: linear-gradient(to right, #e3f2fd, #f1f8e9); }
    .form-container { max-width: 900px; margin: auto; border-radius: 15px; }
    .btn { min-width: 100px; }
    table { border-radius: 10px; overflow: hidden; }
    .icon-btn { border: none; background: none; cursor: pointer; }
</style>
</head>
<body>
<div class="container mt-5">

    <h2 class="text-center text-success mb-4 fw-bold">📚 Registro de Alumnos</h2>

    <?php if($mensaje): ?>
    <div class="alert alert-info text-center fw-semibold shadow-sm"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <!-- Formulario de insertar/buscar -->
    <form method="post" class="p-4 bg-white shadow form-container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="codigo" class="form-label fw-bold">Código</label>
                <input type="number" name="codigo" id="codigo" class="form-control" 
                       value="<?php echo htmlspecialchars($alumno['codigo']); ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" 
                       value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="apellido" class="form-label fw-bold">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" 
                       value="<?php echo htmlspecialchars($alumno['apellido']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="direccion" class="form-label fw-bold">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="form-control" 
                       value="<?php echo htmlspecialchars($alumno['direccion']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label fw-bold">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" 
                       value="<?php echo htmlspecialchars($alumno['telefono']); ?>">
            </div>
        </div>
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <button type="submit" name="insertar" class="btn btn-success">✅ Insertar</button>
            <button type="submit" name="buscar" class="btn btn-info text-white">🔎 Buscar</button>
        </div>
    </form>

    <hr class="my-5">

    <h4 class="text-success fw-bold">📋 Lista de Alumnos</h4>
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-success text-center">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if($listado && mysqli_num_rows($listado) > 0): ?>
                <?php while($fila = mysqli_fetch_assoc($listado)): ?>
                    <tr>
                        <td><?php echo $fila['codigo']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['apellido']; ?></td>
                        <td><?php echo $fila['direccion']; ?></td>
                        <td><?php echo $fila['telefono']; ?></td>
                        <td class="text-center">
                            <!-- Formulario para modificar -->
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="codigo" value="<?php echo $fila['codigo']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>">
                                <input type="hidden" name="apellido" value="<?php echo htmlspecialchars($fila['apellido']); ?>">
                                <input type="hidden" name="direccion" value="<?php echo htmlspecialchars($fila['direccion']); ?>">
                                <input type="hidden" name="telefono" value="<?php echo htmlspecialchars($fila['telefono']); ?>">
                                <button type="submit" name="modificar" class="icon-btn text-warning" title="Modificar">
                                    ✏️
                                </button>
                            </form>
                            <!-- Formulario para eliminar -->
                            <form method="post" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este alumno?');">
                                <input type="hidden" name="codigo" value="<?php echo $fila['codigo']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>">
                                <input type="hidden" name="apellido" value="<?php echo htmlspecialchars($fila['apellido']); ?>">
                                <input type="hidden" name="direccion" value="<?php echo htmlspecialchars($fila['direccion']); ?>">
                                <input type="hidden" name="telefono" value="<?php echo htmlspecialchars($fila['telefono']); ?>">
                                <button type="submit" name="eliminar" class="icon-btn text-danger" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">🙁 No hay alumnos registrados</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
