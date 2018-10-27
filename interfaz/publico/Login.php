<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 12/05/2018
 * Time: 17:02
 */
session_start();


require_once '../../persistencia/UsuarioDAO.php';
require_once '../../objetos/Usuario.php';
require_once '../../objetos/Acceso.php';

include_once '../templates/Template.php';
$template = new Template('../../');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "El login introducido es: $username<br>";
    echo "El password encriptado es: $password<br>";
    if (isset($username) && isset($password)) {

        $usuarioDao = UsuarioDAO::singletonUsuario();
        $u = $usuarioDao->getLoginPassword($username, $password);
        if (!is_null($u)) {
            //Guardar datos de este usuario en la sessión
            $_SESSION['username'] = $u->getUsername();
            $_SESSION['profileImage'] = $u->getProfileImage();
            $_SESSION['ultimoAceso'] = $u->getAcceso()->getUltimoAcceso();
            $_SESSION['rol'] = $u->getAcceso()->getRol();

            header('Location: ../../index');
        }else {
            header('Location: login?identificado=1');

        }
    }
}

if(!empty($_SESSION)){

    header('Location: ../../index');
}
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

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" rel="script" src="../../js/materialize.js"></script>
    <script type="text/javascript" rel="script" src="../../js/menu.js"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<?php echo $template->navBar(null);?>
<div class="columnaMenu" id="colmenu">
    <?php echo $template->menu();?>
</div>
<div class="columnaMain">
    <div class="section no-pad-bot" id="index-banner">
        <div class="light-green lighten-4">
            <div class="columnaMainLeft" style="margin: auto">
                <img class="responsive-img" src="../app_images/logo.png">
            </div>
            <div class="columnaMainRight">
                <?php
                if (isset($_GET['identificado']))
                    if ($_GET['identificado'] == 1) {
                        ?>
                        <span style='color:red; text-align: center'>
                            <b>Authentication failed. Try again</b>
                        </span>
                        <?php
                    }
                ?>
                <form method="post" action="Login" name="login">
                    <label for="user" class="text-lighten-2"><h6><strong>User</strong></h6></label>
                    <input id="user" type="text" name="username" required/><br/>
                    <label for="pass"><h6><strong>Password</strong></h6></label>
                    <input id="pass" type="password" name="password" required/><br/>
                    <button class="btn waves-effect waves-light light-blue" type="submit" name="submit" value="enviar" onclick="cifrar()">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $template->footer();?>

<script src="../../js/sha256.js"></script>
<script>
    function cifrar(){
        var input_pass = document.getElementById("pass");
        if($('#user').val() !== ''){
            input_pass.value = sha256(input_pass.value);
        }
    }
</script>
</body>
</html>
