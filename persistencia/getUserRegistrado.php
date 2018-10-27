<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 16/05/2018
 * Time: 22:45
 */

require 'UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['nameUser'])) {
        $parametro = $_GET['nameUser'];
        $resultado = UsuarioDAO::singletonUsuario()->getUsuarioExiste($parametro);
        $dato["mensaje"] = $resultado;
        print json_encode($dato);

    } else {
        print json_encode( //Otro error
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}