<?php
include_once 'dConexion.php';

class dAlumno {
    private $codigo;
    private $nombre;
    private $apellido;
    private $direccion;
    private $telefono;
    
    function __construct($cod, $nom, $ape, $dir, $tel) {
        $this->codigo = $cod;
        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->direccion = $dir;
        $this->telefono = $tel;
    }

    function Adicionar() {
        $cone = new dConexion();
        $con = $cone->Conectar();
        $respuesta = false;
        try {
            mysqli_begin_transaction($con);
            $consulta = "INSERT INTO alumno (codigo, nombre, apellido, direccion, telefono) 
                         VALUES ('$this->codigo', '$this->nombre', '$this->apellido', '$this->direccion', '$this->telefono')";
            $resultado = mysqli_query($con, $consulta);
            
            if ($resultado) {
                mysqli_commit($con);
                $respuesta = true;
            } else {
                mysqli_rollback($con);
            }
            mysqli_close($con);
        } catch (Exception $ex) {
            mysqli_rollback($con);
            mysqli_close($con);
        }
        return $respuesta;
    }
}
