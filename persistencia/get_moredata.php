<?php

session_start();
include_once 'Conexion.php';
include_once 'GaleriaDAO.php';
include_once '../objetos/Galeria.php';
include_once 'UsuarioDAO.php';
include_once '../objetos/Usuario.php';
include_once 'SubsDAO.php';
include_once '../objetos/Subs.php';

if (isset($_POST['getdata'])) {

    if(empty($_SESSION)){
        $username = null;

    }else{
        $username = $_SESSION['username'];
    }

    $lim = $_POST['getdata'];
    $autorId = $_POST['autor'];

    $autorDao = UsuarioDAO::singletonUsuario();
    $autor = $autorDao->getUsuario($autorId);

    $galeriaDao = GaleriaDAO::singletonGaleria();
    $galerias2 = $galeriaDao->getLimGaleriasByUser($autorId, $lim);
    if(!empty($galerias2)){
        foreach ($galerias2 as $value) { ?>
            <div class="vikash" id="<?php echo $value->getId(); ?>">
                <div class="col s12">
                    <div class="card large <?php
                    $subsDao = SubsDAO::singletonSubs();
                    $usuarioDao = UsuarioDAO::singletonUsuario();
                    $userId = $usuarioDao->getIdByName($username);
                    $noSub = $subsDao->getSubTipo($userId, $autor->getId());
                    if( $value->getTipo() > $noSub && $autor->getUsername() !== $username ){ echo 'lock';} ?> ">
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
                                <span class="card-title"><strong><?php echo $value->getvisitas(); ?> Views</strong></span>
                            </a>
                        </div>
                        <div class="card-content">
                            <a onclick="showPopUp(<?php echo "'".$username."'"; ?>, <?php echo "'".$autor->getUsername()."'"; ?>, <?php echo $value->getId(); ?>, <?php echo $value->getTipo(); ?>, <?php echo $noSub; ?>)">
                                <h5><?php echo $value->getNombre(); ?></h5>
                            </a>
                            <a style="float: right" onclick="showPopUp(<?php echo "'".$username."'"; ?>, <?php echo "'".$autor->getUsername()."'"; ?>, <?php echo $value->getId(); ?>, <?php echo $value->getTipo(); ?>, <?php echo $noSub; ?>)">comments</a>
                        </div>
                    </div>
                </div>
            </div>
<?php   }
    }
} ?>


