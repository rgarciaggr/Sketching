<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 04/06/2018
 * Time: 0:26
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
            <div class="lighten-4">
                <div class="columnaUploadGallery">
                    <form method="post" action="facturas" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s5" style="float: left">
                                <input type="month" name="date" value="<?php echo $date; ?>">
                                <button class=" btn waves-effect waves-light btn-small blue" type="submit">filter by month</button>
                            </div>
                        </div>
                    </form>
                    <h5 class="center">subscriptions</h5>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Amount</th>
                                <th>date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $listaEmisor = $pagosDao->getPagosByDate($date);
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
                                            <?php echo $usuarioDao->getUsuario($value->getDestinatario())->getUsername(); ?>
                                        </td>
                                        <td>
                                            <?php echo $value->getCantidad(); ?>
                                        </td>
                                        <td>
                                            <?php echo $value->getFecha(); ?>
                                        </td>
                                        <td>
                                            <?php if ($value->getEstado() === 'pending') { ?>
                                                <form method="post" action="facturas" enctype="multipart/form-data">
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
                                                </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php echo $template->footer();?>
    </body>
</html>