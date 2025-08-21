<?php
include './dConexion.php';
class dAlumno {
    //put your code here
    private $codigo;
    private $nombre;
    private $apellido;
    private $direccion;
    private $telefono;
    
    //construct
    function __construct($cod, $nom, $ape, $dir, $tel) {
        $this->codigo = $cod;
        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->direccion = $dir;
        $this->telefono = $tel;
    }
    function Adicionar() {
        $cone= new dConexion();
        $respuesta=true;
        try {
            $con=$cone->Conectar();
            mysqli_begin_transaction($con);
            $consulta="insert into alumno(codigo,nombre,apellido,direccion) values "."($this->codigo,$this->nombre,$this->apellido,$this->direccion,$this->telefono);";
            $resultado= mysqli_query($con, $consulta);
            if ($resultado) {
                $respuesta= mysqli_rollback($con);
            } else {
                $respuesta= mysqli_commit($con);
            }
            mysqli_close($con);
        } catch (Exception $ex) {
            try{
                mysqli_close($con);
            } catch (Exception $ex) {

            }
        }
    }
}
