<?php
include_once 'dConexion.php';

class dAlumno {
    private $codigo, $nombre, $apellido, $direccion, $telefono;

    function __construct($cod = "", $nom = "", $ape = "", $dir = "", $tel = "") {
        $this->codigo    = trim($cod);
        $this->nombre    = trim($nom);
        $this->apellido  = trim($ape);
        $this->direccion = trim($dir);
        $this->telefono  = trim($tel);
    }

    // 🔹 Verifica que todos los campos tengan valores
    private function validarCampos() {
        return !empty($this->codigo) &&
               !empty($this->nombre) &&
               !empty($this->apellido) &&
               !empty($this->direccion) &&
               !empty($this->telefono);
    }

    // 🔹 Adicionar alumno
    function Adicionar() {
        if (!$this->validarCampos()) {
            return "error_campos"; // Faltan datos
        }

        $con = (new dConexion())->Conectar();
        $sql = "INSERT INTO alumno (codigo, nombre, apellido, direccion, telefono) 
                VALUES ('$this->codigo','$this->nombre','$this->apellido','$this->direccion','$this->telefono')";
        try {
            $res = mysqli_query($con, $sql);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { 
                return "error_duplicado"; // Código ya existe
            } else {
                return "error_bd: " . $e->getMessage();
            }
        }
        mysqli_close($con);
        return $res ? "ok" : "error";
    }

    // 🔹 Modificar alumno
    function Modificar() {
        if (!$this->validarCampos()) {
            return "error_campos";
        }

        $con = (new dConexion())->Conectar();
        $sql = "UPDATE alumno 
                SET nombre='$this->nombre', apellido='$this->apellido', direccion='$this->direccion', telefono='$this->telefono'
                WHERE codigo='$this->codigo'";
        $res = mysqli_query($con, $sql);
        $filas = mysqli_affected_rows($con);
        mysqli_close($con);

        return ($filas > 0) ? "ok" : "no_existe";
    }

    // 🔹 Eliminar alumno (validando todos los campos)
    function Eliminar() {
        if (!$this->validarCampos()) {
            return "error_campos"; 
        }

        $con = (new dConexion())->Conectar();

        // 1️⃣ Verificar que los datos coincidan exactamente
        $sqlCheck = "SELECT * FROM alumno 
                     WHERE codigo='$this->codigo' 
                     AND nombre='$this->nombre' 
                     AND apellido='$this->apellido' 
                     AND direccion='$this->direccion' 
                     AND telefono='$this->telefono'";
        $resCheck = mysqli_query($con, $sqlCheck);

        if (mysqli_num_rows($resCheck) === 0) {
            mysqli_close($con);
            return "error_no_coincide"; // Los datos no coinciden
        }

        // 2️⃣ Si coinciden, eliminar
        $sql = "DELETE FROM alumno WHERE codigo='$this->codigo'";
        $res = mysqli_query($con, $sql);
        $filas = mysqli_affected_rows($con);
        mysqli_close($con);

        return ($filas > 0) ? "ok" : "no_existe";
    }

    // 🔹 Buscar alumno
    function Buscar() {
        if (empty($this->codigo)) {
            return "error_codigo"; // Buscar requiere al menos el código
        }

        $con = (new dConexion())->Conectar();
        $sql = "SELECT * FROM alumno WHERE codigo='$this->codigo'";
        $res = mysqli_query($con, $sql);
        $fila = mysqli_fetch_assoc($res);
        mysqli_close($con);

        return $fila ?: "no_existe";
    }
}
?>
