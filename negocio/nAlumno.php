<?php
include_once "../datos/dAlumno.php";

class nAlumno {
    private $m;

    function __construct($cod, $nom, $ape, $dir, $tel) {
        $this->m = new dAlumno($cod, $nom, $ape, $dir, $tel);
    }

    function insertar() {
        $res = $this->m->Adicionar();
        if ($res) {
            echo '<div class="alert alert-success">Se registró correctamente el alumno</div>';
        } else {
            echo '<div class="alert alert-danger">No se registró correctamente el alumno</div>';
        }
    }

    // Aquí podrías agregar modificar(), eliminar(), buscar()
}
