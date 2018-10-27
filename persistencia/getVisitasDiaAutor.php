<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 04/06/2018
 * Time: 21:00
 */

require_once 'VisitasDiaDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['autor'])) {
        $parametro = $_POST['autor'];
        $resultado = VisitasDiaDAO::singletonVisitasDia()->getVisitasByAutor($parametro);
        print json_encode($resultado);

    } else {
        $resultado = VisitasDiaDAO::singletonVisitasDia()->getVisitasUltimaSemana();
        print json_encode($resultado);
    }
}