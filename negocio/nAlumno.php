<?php
include_once "../datos/dAlumno.php";

class nAlumno {
    private $m;

    function __construct($cod=0, $nom='', $ape='', $dir='', $tel='') {
        $this->m = new dAlumno($cod, $nom, $ape, $dir, $tel);
    }

    function insertar() { return $this->m->Adicionar(); }
    function modificar() { return $this->m->Modificar(); }
    function eliminar()  { return $this->m->Eliminar(); }
    function buscar()   { return $this->m->Buscar(); }

    function listar() {
        $con = (new dConexion())->Conectar();
        $res = mysqli_query($con, "SELECT * FROM alumno");
        mysqli_close($con);
        return $res;
    }
}
?>
