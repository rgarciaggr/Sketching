<?php
session_start();
include_once '../../persistencia/UsuarioDAO.php';
include_once '../../persistencia/SubsDAO.php';
include_once '../../persistencia/PagoDAO.php';
include_once '../../objetos/Usuario.php';
include_once '../../objetos/Subs.php';
include_once '../../objetos/Pago.php';

if(isset($_GET['auth'])){

}else{
    header('Location: 404');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sketching subscription</title>


        <link rel="icon" href="/interfaz/app_images/icono.png">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="../../css/materialize.css"  media="screen,projection"/>

    </head>
    <body>
        <div class="center">
            <h1>Thanks for subscribing!!</h1>
            <h5>The 90% of your subscription goes entirely to the authors.</h5>
        </div>
        <br>
        <div class="center"><a href="/index"><h3>Continue to the page</h3></a></div>
    </body>
</html>
