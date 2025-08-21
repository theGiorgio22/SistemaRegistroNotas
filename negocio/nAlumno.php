<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nAlumno
 *
 * @author Usuario
 */
class nAlumno {
    //put your code here
    public $m;
    function __construct($cod, $nom, $ape, $dir, $tel) {
        $this->m=new dAlumno($cod,$nom,$ape,$dir,$tel);
    }
    function adicionar(){
        $res=$this->m->Adicionar();
        if($res) {
            echo 'Se registró correctamente el alumno';
        } else {
            echo 'No se registró correctamente el alumno';
        }
    }
}
