<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 08/06/2018
 * Time: 1:28
 */

session_start();
include_once '../templates/Template.php';
include_once '../../objetos/Usuario.php';
include_once '../../persistencia/GaleriaDAO.php';
include_once '../../persistencia/SubsDAO.php';

if(empty($_SESSION)){
    //Elementos Logged out
    $profImageURL = null;
}else{
    //Elementos logged in
    $profileImage = $_SESSION['profileImage'];
    $profImageURL = '../../interfaz/profile_images/profile_'.$profileImage;
}

if(isset($_GET['follow'])){
    $type = $_GET['follow'];
    if($type === 'to'){
        $busqueda = $_GET['autor'];
        $usuarioDao = SubsDAO::singletonSubs();
        $listaUsuarios = $usuarioDao->getSubsByUser($busqueda);
    }else{
        $busqueda = $_GET['autor'];
        $usuarioDao = SubsDAO::singletonSubs();
        $listaUsuarios = $usuarioDao->getSubsByAutor($busqueda);
    }
    if(empty($listaUsuarios)){
        $notFound = true;
    } else {
        $notFound = false;
    }
}else{
    header('Location index');
}


$template = new Template('../../');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sketching</title>


    <link rel="icon" href="../app_images/icono.png">


    <link href="../../css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../../css/estilo_menu.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="../../css/materialize.css"  media="screen,projection"/>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" rel="script" src="../../js/materialize.js"></script>
    <script type="text/javascript" rel="script" src="../../js/menu.js"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<?php echo $template->navBar($profImageURL); ?>
<div class="columnaMenu" id="colmenu">
    <?php echo $template->menu(); ?>
</div>
<div style="background-color: lightgrey">
    <div class="columnaUploadGallery" id="colmain">
        <?php
            if($notFound){
                echo'<p><h4 class="center">Invalid search: User not found</h4></p>';
            } else {
                if($type === 'to'){
                    echo '<h3 class="center">People you follow</h3>';
                }else{
                    echo '<h3 class="center">Followers</h3>';
                }
            ?>
            <table class="striped responsive-table">
                <thead>
                <tr>
                    <th class="center"></th>
                    <th class="center">Author</th>
                    <th class="center">Galleries</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($listaUsuarios as $valor){
                    $galeriaDAO = GaleriaDAO::singletonGaleria();
                    $count = $galeriaDAO->countGaleriasByUser($valor->getId());
                    echo '<tr>
                        <td class="col s1" width="16%">
                            <a href="../../'. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="s1">
                                    <img src="' . Funciones::showImageProfile('/interfaz/profile_images/profile_' . $valor->getProfileImage(), '../../') . '" alt="" class="circle" height="80px" width="80px">
                                </div>
                            </div>
                            </a>
                        </td>
                        <td class="center">
                        <a href="../../'. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s10">
                                    <h5 class="black-text">'. $valor->getUsername() .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
                        <td class="center">
                        <a href="../../'. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s4">
                                    <h5 class="black-text">'. $count .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
              </tr>';
                } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<?php echo $template->footer(); ?>

</body>
</html>