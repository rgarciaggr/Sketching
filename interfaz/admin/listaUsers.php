<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 12/05/2018
 * Time: 17:01
 */

session_start();
include_once '../templates/Template.php';
include_once '../../objetos/Usuario.php';
include_once '../../persistencia/UsuarioDAO.php';
include_once '../../persistencia/GaleriaDAO.php';
include_once '../../persistencia/SubsDAO.php';
include_once '../../persistencia/PagoDAO.php';

$usuarioDao = UsuarioDAO::singletonUsuario();
$subsDao = SubsDAO::singletonSubs();
$pagoDao = PagoDAO::singletonPago();
$galeriaDao = GaleriaDAO::singletonGaleria();

if(empty($_SESSION)){
    //Elementos Logged out
    $profImageURL = null;
    header('Location: index');
}else{
    //Elementos logged in
    if($_SESSION['rol'] !== '0'){
        header('Location: index');
    }
    $profileImage = $_SESSION['profileImage'];
    $profImageURL = '../../interfaz/profile_images/profile_'.$profileImage;
}

if(isset($_GET['search'])) {
    $busqueda = $_GET['search'];
    $listaUsuarios = $usuarioDao->getBusquedaUsuarios($busqueda);

    if (empty($listaUsuarios)) {
        $notFound = true;
    } else {
        $notFound = false;
    }

}else{
    $listaUsuarios = $usuarioDao->getBusquedaUsuarios('');

    if (empty($listaUsuarios)) {
        $notFound = true;
    } else {
        $notFound = false;
    }

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
        <h4 class="black-text center">Administration Panel</h4>
        <form method="get" name="search" action="facturas">
            <div class="row">
                <div class="input-field col s5" style="float: left">
                    <input type="month" name="date">
                    <button class=" btn waves-effect waves-light btn-small blue" type="submit">filter by month</button>
                </div>
            </div>
        </form>
        <form method="get" name="search" action="listaUsers" class="s12">
            <div class="row s9">
                <div class="input-field col s5">
                    <p>
                        <i class="black-text material-icons prefix">search</i>
                        <input id="search" name="search" type="search" class="validate">
                        <label for="search">Search for Users</label>
                    </p>
                </div>
            </div>
        </form>

        <?php
            if($notFound){
                echo'<p><h4 class="center">Invalid search: User not found</h4></p>';
            } else {
            ?>
            <table class="striped responsive-table">
                <thead>
                <tr>
                    <th class="center"></th>
                    <th class="center">Author</th>
                    <th class="center">Name</th>
                    <th class="center">Last Name</th>
                    <th class="center">Followers</th>
                    <th class="center">Galleries</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($listaUsuarios as $valor){
                    $count = $galeriaDao->countGaleriasByUser($valor->getId());
                    $countSubs = $subsDao->countSubsByAutor($valor->getId());
                    echo '<tr>
                        <td class="col s1" width="16%">
                            <a href="admin?userAdmin='. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="s1">
                                    <img src="' . Funciones::showImageProfile('/interfaz/profile_images/profile_' . $valor->getProfileImage(), '../../') . '" alt="" class="circle" height="80px" width="80px">
                                </div>
                            </div>
                            </a>
                        </td>
                        <td class="center">
                        <a href="admin?userAdmin='. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s4">
                                    <h5 class="black-text">'. $valor->getUsername() .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
                        <td class="center">
                        <a href="admin?userAdmin='. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s3">
                                    <h5 class="black-text">'. $valor->getNombre() .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
                        <td class="center">
                        <a href="admin?userAdmin='. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s3">
                                    <h5 class="black-text">'. $valor->getAppelido() .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
                        <td class="center">
                        <a href="admin?userAdmin='. $valor->getUsername() .'">
                            <div class="row valign-wrapper">
                                <div class="col s4">
                                    <h5 class="black-text">'. $countSubs .'</h5>
                                </div>
                            </div>    
                            </a>     
                        </td>
                        <td class="center">
                        <a href="admin?userAdmin='. $valor->getUsername() .'">
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
    </div>
</div>
<?php } echo $template->footer(); ?>

</body>
</html>