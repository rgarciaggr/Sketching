<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 08/06/2018
 * Time: 2:22
 */
require 'UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['busqueda'])) {
        $parametro = $_POST['busqueda'];
        $resultado = UsuarioDAO::singletonUsuario()->getBusquedaAutocomp($parametro);
//        $lim = count($resultado);
//        foreach ($resultado as $pos => $value){
//            print '"' . $value[0] . '" : null' /*"' . $value[1]*/;
//            if($pos < $lim - 1){
//                print ' ,';
//            }
//        }
        $data['mensaje'] = $resultado;
        print json_encode($resultado);

    } else {
        print json_encode( //Otro error
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}