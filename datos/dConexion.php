<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dConexion
 *
 * @author Usuario
 */
class dConexion {
    //put your code here
    private $servidor;
    private $basededatos;
    private $puerto;
    private $usuario;
    private $clave;
    //construc..
    function __construct($servidor, $basededatos, $puerto, $usuario, $clave) {
        $this->servidor = "localhost";
        $this->basededatos = "bdregistronotas";
        $this->puerto = 3308;
        $this->usuario = "root";
        $this->clave = "";
    }
    function Conectar() {
        try {
            $con = mysqli_connect($this->servidor, $this->usuario, $this->clave, $this->basededatos, $this->puerto);

            if (!$con) {
                echo 'Error en la conexión a la base de datos';
                return null;
            } else {
                // echo 'Conexión exitosa';
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
        return $con; //Retorna una conexion
    }
}
