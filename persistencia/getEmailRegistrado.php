<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 17/05/2018
 * Time: 21:25
 */
require 'UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['email'])) {
        $parametro = $_GET['email'];
        $resultado = UsuarioDAO::singletonUsuario()->getEmailExiste($parametro);
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