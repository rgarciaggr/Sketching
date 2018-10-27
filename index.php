<?php
/**
* Created by PhpStorm.
* User: Kuro
* Date: 12/05/2018
* Time: 0:56
*/

session_start();

include_once 'persistencia/UsuarioDAO.php';
include_once 'persistencia/GaleriaDAO.php';
include_once 'persistencia/SubsDAO.php';
include_once 'persistencia/PagoDAO.php';
include_once 'persistencia/RedesSocialesDAO.php';

include_once 'objetos/Usuario.php';
include_once 'objetos/Galeria.php';
include_once 'objetos/Subs.php';
include_once "objetos/VisitasDia.php";

include_once 'interfaz/templates/Funciones.php';

$usuarioDao = UsuarioDAO::singletonUsuario();
$subsDao = SubsDAO::singletonSubs();
$pagoDao = PagoDAO::singletonPago();
$galeriaDao = GaleriaDAO::singletonGaleria();
$redesDao = RedesSocialesDAO::singletonSociales();

$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
$elements = explode('/', $path);                // Split path on slashes

if(empty($elements[0])) {                       // No path elements means home

} else{
    if(count($elements) >= 2){
        header('Location: ../index');
    }else{
        if(empty($elements[0]) || $elements[0] === 'index'){
            //pagina principal
        }else{
            $userSelec = $elements[0];

            $autor = $usuarioDao->getUserbyName($userSelec);
            if(empty($autor)){
                header('Location: interfaz/publico/Busqueda.php');
            }
        }
    }
}

if(isset($_POST['logout'])){
    session_destroy();
    session_start();
}

if(isset($_POST['follow'])){
    $user = $_SESSION['username'];
    $userId = $usuarioDao->getIdByName($user);
    $autorId = $usuarioDao->getIdByName($userSelec);

    $resultado = $subsDao->addSub($userId, $autorId, 0);
}

if(isset($_POST['unfollow'])){
    $user = $_SESSION['username'];

    $userId = $usuarioDao->getIdByName($user);
    $autorId = $usuarioDao->getIdByName($userSelec);
    $resultado = $subsDao->unSub($userId, $autorId);
    $pagoDao->addPago($userId, $autorId, 'cancel', 0);
}

//var_dump($_SESSION);

if(empty($_SESSION)){
    //Elementos Logged out
    $profImageURL = null;
    $username = null;

}else{
    //Elementos logged in
    $username = $_SESSION['username'];
    $profileImage = $_SESSION['profileImage'];
    $profImageURL = 'interfaz/profile_images/profile_'.$profileImage;
}

include 'interfaz/templates/Template.php';
$template = new Template('');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Sketching</title>


    <link rel="icon" href="interfaz/app_images/icono.png">


    <link href="css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/estilo_menu.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/popup.css"  media="screen,projection"/>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    
    <script type="text/javascript" rel="script" src="js/materialize.js"></script>
    <script type="text/javascript" rel="script" src="js/menu.js"></script>
    <script type="text/javascript" rel="script" src="js/infinitescroll.js"></script>
    <script type="text/javascript" rel="script" src="js/init.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <?php echo $template->navBar($profImageURL); ?>
    <div class="columnaMenu" id="colmenu" >
        <?php echo $template->menu(); ?>
    </div>
    <div class="columnaMain" id="colmain">
        <?php if(empty($autor)){
            $numVisitas = $galeriaDao->countAllViews();
            $numGaleries = $galeriaDao->countGlerias();
            $numUsers = $usuarioDao->countUsers();
            $array = $usuarioDao->getTopFive();
            echo $template->indexDefault($numVisitas, $numUsers, $numGaleries, $array);
        }else{
            $galerias1 = $galeriaDao->getUltGaleriasByUser($autor->getUsername());
            ?>
        <div class="columnaPostLeft">
            <?php if(isset($username) && $username === $autor->getUsername()){ ?>
                <div class="valign-wrapper">
                    <div class="col s8">
                        <a href="interfaz/privado/uploadgallery">
                            <button class="btn waves-effect waves-light light-blue">New Gallery</button>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <p hidden id="need" aria-valuenow="<?php echo $autor->getId(); ?>"></p>
            <div class="row" id="alldata">
            <?php if(!empty($galerias1)){
                foreach ($galerias1 as $value) { ?>
                <div class="vikash" id="<?php echo $value->getId(); ?>">
                    <div class="col s12">
                        <div class="card large <?php
                        $userId = $usuarioDao->getIdByName($username);
                        $noSub = $subsDao->getSubTipo($userId, $autor->getId());
                        if( $value->getTipo() > $noSub && $autor->getUsername() !== $username ){ echo 'lock';} ?>">
                            <div class="card-image">
                                <a onclick="showPopUp(<?php echo "'".$username."'"; ?>, <?php echo "'".$autor->getUsername()."'"; ?>, <?php echo $value->getId(); ?>, <?php echo $value->getTipo(); ?>, <?php echo $noSub; ?>)">
                                    <img class="responsive-img materialboxed" src="interfaz/galerias/<?php echo $autor->getUsername().'/'.$value->getId().'/0.jpg'; ?>">
                                    <span class="card-title popup" style="top: 0;bottom: auto; left: 40%">
                                        <strong>
                                        <?php if($value->getTipo() == 1){
                                            echo '1€ sub';
                                        }elseif ($value->getTipo() == 3){
                                            echo '3€ sub';
                                        }elseif ($value->getTipo() == 5){
                                            echo '5€ sub';
                                        }else{
                                            echo 'Public';
                                        } ?> Gallery</strong>
                                        <span class="popuptext" id="myPopup<?php echo $value->getId(); ?>">You aren't subscribed to this content!</span>
                                    </span>
                                    <span class="card-title"><strong><?php echo $value->getVisitas(); ?> Views</strong></span>
                                </a>
                            </div>
                            <div class="card-content">
                                <a onclick="showPopUp(<?php echo "'".$username."'"; ?>, <?php echo "'".$autor->getUsername()."'"; ?>, <?php echo $value->getId(); ?>, <?php echo $value->getTipo(); ?>, <?php echo $noSub; ?>)">
                                    <h5><?php echo $value->getNombre(); ?></h5>
                                </a>
                                <!--a style="float: right" onclick="showPopUp(<?php echo "'".$username."'"; ?>, <?php echo "'".$autor->getUsername()."'"; ?>, <?php echo $value->getId(); ?>, <?php echo $value->getTipo(); ?>, <?php echo $noSub; ?>)">comments</a-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            }else{ ?>
                <h5 class="center"><strong>Wow, looks like this Creator hasn´t uploaded any Gallery yet...</strong></h5>
           <?php } ?>
            </div>
        </div>
        <div class="columnaPostRight">
            <div class="card-panel grey lighten-5 z-depth-1 col s12">
                <?php if(isset($username) && $username === $userSelec){ ?>
                    <div class="valign-wrapper">
                        <div class="col s8">
                            <a href="interfaz/privado/Profile">
                                <button class="btn waves-effect waves-light light-blue">Edit Profile</button>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <div class="row valign-wrapper">
                    <div class="col s4">
                        <img class="circle" src="<?php echo Funciones::showImageProfile('interfaz/profile_images/profile_' . $autor->getProfileImage(), ''); ?>" width="60px" height="60px">
                    </div>
                    <div class="col s8">
                        <span class="black-text">
                            <h5>
                                <b id="autor_name">
                                    <?php echo $autor->getUsername(); ?>
                                </b>
                            </h5>
                        </span>
                    </div>
                </div>
                <div class="col s12">
                    <span class="black-text center-align">
                            <h6>
                                <b>
                                    <?php
                                    $sub = $subsDao->countSubsByAutor($autor->getId());
                                    echo $sub; ?>
                                </b>
                                Followers<br><br>
                                <?php if(isset($username) && $userSelec !== $username){
                                    $usuario = $usuarioDao->getUserbyName($username);
                                    $follow = $subsDao->getSubByUserAndAutor($usuario->getId(), $autor->getId());
                                    if(empty($follow)){ ?>
                                        <form method="post" action="<?php echo $userSelec; ?>" enctype="multipart/form-data">
                                            <button class="btn waves-effect waves-light white black-text" name="follow">Follow</button>
                                        </form>
                                <?php }else{ ?>
                                        <form method="post" action="<?php echo $userSelec; ?>" enctype="multipart/form-data">
                                            <button class="btn waves-effect waves-light relaxing-red black-text" name="unfollow" >Unfollow</button>
                                        </form>
                                <?php }
                                } ?>
                            </h6>
                        <?php  if(empty($autor->getDescripcion())){
                            echo 'This creator doesn´t have any description yet...';
                        }else{
                            echo $autor->getDescripcion();
                        } ?>
                    </span>
                </div>
                <br>
                <br>
                <div class="center">
                    <?php
                    $redes = $redesDao->getRedes($username);
                    if($redes[0] !== null && $redes[0] !== ''){ ?>
                        <a class="twitter-follow-button" href="https://twitter.com/<?php echo $redes[0]; ?>" data-size="large"> Follow @<?php echo $redes[0]; ?></a>
                        <br>
                    <?php
                    }
                    if($redes[1] !== null && $redes[1] !== ''){ ?>
                        <a class="twitter-follow-button" target="_blank" href="https://www.instagram.com/<?php echo $redes[1]; ?>" data-size="large"><img class="responsive-img" style="width: 30px; height: 30px" src="interfaz/app_images/ig_icon.png"></a>
                    <?php } ?>
                </div>
            </div>
            <?php if(isset($username) && $userSelec !== $username){ ?>
            <div class="card">
                <div class="card-content center">
                    <p><strong>Rewards</strong></p>
                </div>
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a href="#tab1">1€ Reward</a></li>
                        <li class="tab"><a class="active" href="#tab2">3€ Reward</a></li>
                        <li class="tab"><a href="#tab3">5€ Reward</a></li>
                    </ul>
                </div>
                <div class="card-content grey lighten-4">
                    <div id="tab1" class="center">
                        <p>Access to new content each month</p>
                        <br>
                        <form action="paypal/payments" method="post" id="paypal_form" target="_blank">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions" >
                            <input type="hidden" name="no_note" value="1" >
                            <input type="hidden" name="lc" value="ESP" >
                            <input type="hidden" name="currency_code" value="EUR" >
                            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest" >
                            <input type="hidden" name="first_name" value="Customer's First Name" >
                            <input type="hidden" name="last_name" value="Customer's Last Name" >
                            <input type="hidden" name="payer_email" value="robert5_gg-buyer@hotmail.com" >
                            <input type="hidden" name="item_name" value="Subscription">
                            <input type="hidden" name="item_number" value="1">
                            <input type="hidden" name="a3" value="1.00">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="M">
                            <input type="hidden" name="custom" value="<?php
                            $usuario = $usuarioDao->getUserbyName($username);
                            echo $usuario->getId() . " " .$autor->getId(); ?>" >
                            <input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal, la forma rápida y segura de pagar en Internet.">
                            <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
                        </form>
                        <!-- form action="interfaz/privado/Subscribe" method="post" enctype="multipart/form-data">
                            <input class="btn waves-effect waves-light light-blue" type="submit" name="subscribe" value="1Bypass">
                            <input type="hidden" name="autor" value="<?php echo $userSelec; ?>">
                        </form -->
                    </div>
                    <div id="tab2" class="center">
                        <p>Access to my WIP</p>
                        <br>
                        <form action="paypal/payments" method="post" id="paypal_form" target="_blank">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions" >
                            <input type="hidden" name="no_note" value="1" >
                            <input type="hidden" name="lc" value="ESP" >
                            <input type="hidden" name="currency_code" value="EUR" >
                            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest" >
                            <input type="hidden" name="first_name" value="Customer's First Name" >
                            <input type="hidden" name="last_name" value="Customer's Last Name" >
                            <input type="hidden" name="payer_email" value="robert5_gg-buyer@hotmail.com" >
                            <input type="hidden" name="item_name" value="Subscription">
                            <input type="hidden" name="item_number" value="3">
                            <input type="hidden" name="a3" value="3.00">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="M">
                            <input type="hidden" name="custom" value="<?php
                            $usuario = $usuarioDao->getUserbyName($username);
                            echo $usuario->getId() . " " .$autor->getId(); ?>" >
                            <input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal, la forma rápida y segura de pagar en Internet.">
                            <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </div>
                    <div id="tab3" class="center">
                        <p>Access to Exclusive content</p>
                        <br>
                        <form action="paypal/payments" method="post" id="paypal_form" target="_blank">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions" >
                            <input type="hidden" name="no_note" value="1" >
                            <input type="hidden" name="lc" value="ESP" >
                            <input type="hidden" name="currency_code" value="EUR" >
                            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest" >
                            <input type="hidden" name="first_name" value="Customer's First Name" >
                            <input type="hidden" name="last_name" value="Customer's Last Name" >
                            <input type="hidden" name="payer_email" value="robert5_gg-buyer@hotmail.com" >
                            <input type="hidden" name="item_name" value="Subscription">
                            <input type="hidden" name="item_number" value="5">
                            <input type="hidden" name="a3" value="5.00">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="M">
                            <input type="hidden" name="custom" value="<?php
                            $usuario = $usuarioDao->getUserbyName($username);
                            echo $usuario->getId() . " " .$autor->getId(); ?>" >
                            <input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal, la forma rápida y segura de pagar en Internet.">
                            <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="card-panel grey lighten-5 z-depth-1 col s12">
                <div class="row valign-wrapper">
                    <div class="col s12 center">
                        <p><strong>Views of this Author on the last Week</strong></p>
                        <br>
                        <div id="chart_div"></div>
                    </div>
                </div>
            </div>

            <?php if(isset($username) && $username === $userSelec){ ?>
            <div class="card-panel grey lighten-5 z-depth-1 col s12 center">
                <div class="row valign-wrapper">
                    <div class="col s12 center">
                        <a href="interfaz/publico/follows?follow=to&autor=<?php echo $userSelec; ?>">
                            <p><strong>Authors you follow</strong></p>
                            <br>
                            <div>
                                <?php

                                $listaFollowers = $subsDao->getLastAutorBySub($username);
                                if($listaFollowers == null){
                                    ?>
                                    <p>No follows yet...</p>
                                    <?php

                                }else{
                                    foreach ($listaFollowers as $value){
                                        $follower = $usuarioDao->getUsuario($value->getAutor()) ?>
                                        <div class="col s2-5">
                                            <a href="<?php echo $follower->getUsername(); ?>">
                                                <img class="circle" src="<?php echo Funciones::showImageProfile('interfaz/profile_images/profile_' . $follower->getProfileImage(), ''); ?>" width="60px" height="60px">
                                            </a>
                                        </div>
                                    <?php } } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="card-panel grey lighten-5 z-depth-1 col s12">
                <div class="row valign-wrapper">
                    <div class="col s12 center">
                        <a href="interfaz/publico/follows?follow=by&autor=<?php echo $userSelec; ?>">
                            <p><strong>Last followers</strong></p>
                            <br>
                            <div>
                                <?php
                                $listaFollowers = $subsDao->getLastSubsByAutor($autor->getUsername());
                                if($listaFollowers == null){
                                    ?>
                                    <p>No followers yet...</p>
                                    <?php
                                }else{
                                foreach ($listaFollowers as $value){
                                    $follower = $usuarioDao->getUsuario($value->getUser()) ?>
                                <div class="col s2-5">
                                    <a href="<?php echo $follower->getUsername(); ?>">
                                        <img class="circle" src="<?php echo Funciones::showImageProfile('interfaz/profile_images/profile_' . $follower->getProfileImage(), ''); ?>" width="60px" height="60px">
                                    </a>
                                </div>
                                <?php } } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
         <?php } ?>
    </div>
    <?php echo $template->footer(); ?>
    <script>

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            let autor = $('#need').attr("aria-valuenow");
            var jsonData = $.ajax({
                type: 'post',
                url: "persistencia/getVisitasDiaAutor",
                dataType: "json",
                async: false,
                data: {
                    autor: autor
                },
            }).responseText;
            let array = JSON.parse(jsonData);
            let views = [];
            array.forEach(function (element) {
                views.push(element.visitas);
            });

            let data = new google.visualization.arrayToDataTable([
                ['', ''],
                ['',  parseInt(views[6])],
                ['',  parseInt(views[5])],
                ['',  parseInt(views[4])],
                ['',  parseInt(views[3])],
                ['',  parseInt(views[2])],
                ['',  parseInt(views[1])],
                ['',  parseInt(views[0])],

            ]);
            // Instantiate and draw our chart, passing in some options.
            const chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, {width: '100%', height: '100%'});
        }


        function showPopUp(user, autor, idGaleria, tipoG, tipoU) {

            if (user === autor) {
                window.location.href = 'interfaz/galerias/gallery?autor=' + autor + '&gal=' + idGaleria;
            } else {
                if (tipoG <= tipoU) {
                    window.location.href = 'interfaz/galerias/gallery?autor=' + autor + '&gal=' + idGaleria;
                } else {
                    var popup = document.getElementById("myPopup" + idGaleria);
                    popup.classList.toggle("show");
                }
            }
        }
    </script>
    <!--script id="dsq-count-scr" src="//sketchingcastelar.disqus.com/count.js" async></script-->
</body>
</html>

