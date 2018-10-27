<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 02/06/2018
 * Time: 16:53
 */

session_start();

include_once '../../persistencia/GaleriaDAO.php';
include_once '../../persistencia/UsuarioDAO.php';
include_once '../../persistencia/SubsDAO.php';
include_once '../../persistencia/PagoDAO.php';

include_once '../../objetos/Galeria.php';
include_once '../../objetos/Usuario.php';
include_once '../../objetos/Subs.php';
include_once '../../objetos/Pago.php';

include_once '../templates/Template.php';

if(empty($_SESSION)){
    $profImageURL = '../profile_images/profile_';
}else{
    //Elementos logged in
    if($_SESSION['rol'] !== '0'){
        header('Location: index');
    }
    $profileImage = $_SESSION['profileImage'];
    $profImageURL = '../profile_images/profile_'.$profileImage;
}
$usuarioDao = UsuarioDAO::singletonUsuario();
$subsDao = SubsDAO::singletonSubs();
$galeriaDao = GaleriaDAO::singletonGaleria();
$pagosDao = PagoDAO::singletonPago();

if(isset($_GET['borrar'])){
    $username = $_GET['borrar'];
    $usuarioDao->borrarUsuario($username);
    var_dump('../galerias/'.$username);
    Funciones::removeDirectory('../galerias/' . $username);
    header('Location: listaUsers');

}elseif(isset($_GET['userAdmin'])){

    $autorName = $_GET['userAdmin'];
    }elseif ($_POST['userAdmin']){
    $autorName = $_POST['userAdmin'];

}else{
    header('Location: index');
}

    $autor = $usuarioDao->getUserByName($autorName);

    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }else{
        $date = '';
    }

    if(isset($_POST['aceptar'])){
        $id = $_POST['aceptar'];
        $pagosDao->updatePago($id, 'payed');
    }

    if(isset($_POST['cancelar'])){
        $id = $_POST['cancelar'];
        $pagosDao->updatePago($id, 'cancel');
    }

    if(isset($_POST['makea'])){
        $usuarioDao->updateRol($autor->getId(), 0);
    }
    if(isset($_POST['undo'])){
        $usuarioDao->updateRol($autor->getId(), 1);
    }


    $template = new Template('../../');
    ?>

    <html>
    <head>
        <meta charset="UTF-8">
        <title>Sketching</title>

        <link rel="icon" href="../app_images/icono.png">


        <link href="../../css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="../../css/estilo_menu.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="../../css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../../css/main.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../../css/popup.css"  media="screen,projection"/>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script type="text/javascript" rel="script" src="../../js/materialize.js"></script>
        <script type="text/javascript" rel="script" src="../../js/menu.js"></script>


        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
    <?php echo $template->navBar($profImageURL);?>
    <div class="columnaMenu" id="colmenu">
        <?php echo $template->menu();?>
    </div>
    <div class="columnaMain">
        <div class="section no-pad-bot" id="index-banner">
            <div class="light-green lighten-4">
                <div class="columnaPostLeft">
                    <div style="width: 30% !important;">
                        <form method="post" action="admin" enctype="multipart/form-data">
                            <input type="month" name="date" value="<?php echo $date; ?>">
                            <button class=" btn waves-effect waves-light btn-small blue" type="submit">filter by month</button>
                            <input type="hidden" name="userAdmin" value="<?php echo $autorName; ?>">
                        </form>
                    </div>
                    <div class="columnaMainLeft">
                        <h5 class="center">subscriptions</h5>
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $listaEmisor = $pagosDao->getPagosByAutor($autor->getId(), $date);
                                if($listaEmisor === null){
                                    ?>
                                    <h4 class="center">No records yet</h4>
                                    <?php
                                }else {
                                    foreach ($listaEmisor as $value) {
                                        $user = $usuarioDao->getUsuario($value->getEmisor()); ?>
                                        <tr>
                                            <td>
                                                <?php echo $user->getUsername(); ?>
                                            </td>
                                            <td class="estado-<?php echo $value->getEstado(); ?>">
                                                <?php echo $value->getEstado(); ?>
                                            </td>
                                            <td>
                                                <?php echo $value->getCantidad(); ?>
                                            </td>
                                            <td>
                                                <?php echo $value->getFecha(); ?>
                                            </td>
                                            <td>
                                                <?php if ($value->getEstado() === 'pending') { ?>
                                                    <form method="post" action="admin" enctype="multipart/form-data">
                                                        <div class="tooltip">
                                                            <button
                                                                class=" btn-floating btn waves-effect waves-light btn-small green"
                                                                type="submit" name="aceptar"
                                                                value="<?php echo $value->getId(); ?>">
                                                                <i class="material-icons right">check</i>
                                                            </button>
                                                            <span class="tooltiptext">Accept</span>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button
                                                                class="btn-floating btn waves-effect waves-light btn-small red"
                                                                type="submit" name="cancelar"
                                                                value="<?php echo $value->getId(); ?>">
                                                                <i class="material-icons right">clear</i>
                                                            </button>
                                                            <span class="tooltiptext">Cancel</span>
                                                        </div>
                                                        <input type="hidden" name="userAdmin"
                                                               value="<?php echo $autorName; ?>">
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="columnaMainRight">
                        <h5 class="center">Subscribed</h5>
                        <table class="striped">
                            <thead>
                            <tr>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $listaAutor = $pagosDao->getPagosByUser($autor->getId(), $date);
                            if($listaAutor === null){
                                ?>
                                <h4 class="center">No records yet</h4>
                                <?php
                            }else {
                                foreach ($listaAutor as $value) {
                                    $user = $usuarioDao->getUsuario($value->getDestinatario()); ?>
                                    <tr>
                                        <td>
                                            <?php echo $user->getUsername(); ?>
                                        </td>
                                        <td class="estado-<?php echo $value->getEstado(); ?>">
                                            <?php echo $value->getEstado(); ?>
                                        </td>
                                        <td>
                                            <?php echo $value->getCantidad(); ?>
                                        </td>
                                        <td>
                                            <?php echo $value->getFecha(); ?>
                                        </td>
                                    </tr>
                                <?php }
                            }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="columnaPostRight">
                    <div class="card-panel grey lighten-5 z-depth-1 col s12">
                        <a href="<?php echo '../../' . $autor->getUsername(); ?>">
                            <div class="row valign-wrapper">
                                <div class="col s4">
                                    <img class="circle" src="<?php echo Funciones::showImageProfile('../profile_images/profile_' . $autor->getProfileImage(), '../../'); ?>" width="60px" height="60px">
                                </div>
                                <div class="col s8">
                                    <span class="black-text">
                                        <h5>
                                            <b>
                                                <?php echo $autor->getUsername(); ?>
                                            </b>
                                        </h5>
                                    </span>
                                </div>
                            </div>
                            <div class="col s12">
                                <span class="black-text center-align">
                                    <p>
                                        <h6>
                                            <b>
                                                <?php
                                                $sub = $subsDao->countSubsByAutor($autor->getId());
                                                echo $sub; ?>
                                            </b>
                                            Followers
                                        </h6>
                                    </p>
                                    <?php echo $autor->getDescripcion(); ?>
                                </span>
                            </div>
                            <br>
                            <div class="center">
                                <form method="post" action="admin" enctype="multipart/form-data">
                                    <?php if($usuarioDao->getUserRol($autor->getId()) !== '0'){ ?>
                                    <button class=" btn btn-large waves-effect waves-light blue" type="submit" name="makea">Make Admin</button>
                                    <?php }else{ ?>
                                        <button class=" btn btn-large waves-effect waves-light blue" type="submit" name="undo">Undo Admin</button>
                                    <?php } ?>
                                    <input type="hidden" name="userAdmin" value="<?php echo $autorName; ?>">
                                </form>
                                <br>
                                <br>
                            </div>
                        </a>
                        <div class="center">
                            <button class="btn waves-effect waves-light btn-small relaxing-red" onclick="deleteUser('<?php echo $autorName; ?>')">Delete User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $template->footer();?>
    <script>
        function deleteUser(user){
            let r = confirm("Are you sure you want to delete your profile?\n This can´t be un done.");
            if (r === true) {
                window.location.href = "admin?borrar=" + user;
            }
        }
    </script>
    </body>
</html>