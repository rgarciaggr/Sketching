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

if(!empty($_SESSION)){
    header('Location: ../../index');
}

include '../templates/Template.php';
$template = new Template('../../');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $name = $_POST['name'];
    $lastName = $_POST['lastname'];
    $birthDate = $_POST['birthdate'];
    $imageProfile = "";


    if (!empty($_FILES['imagefile']['name'])){
        $nombreOriginal=$_FILES['imagefile']['name'];
        $posPunto=strpos($nombreOriginal,".")+1;
        $extensionOriginal=  substr($nombreOriginal, $posPunto, 3);
        //echo "La extensión es: $extensionOriginal";
        $nuevaRuta = "../profile_images/profile_" . $username . "." . $extensionOriginal;
        echo "El nuevo nombre es: $nuevaRuta";
        move_uploaded_file($_FILES['imagefile']['tmp_name'], $nuevaRuta);
        $imageProfile = $username. '.' . $extensionOriginal;
    }

    $usuarioDao = UsuarioDAO::singletonUsuario();
    $user = new Usuario(null, $username, $email, $name, $lastName, $birthDate, $imageProfile,null, new Acceso(null, $password, date('Y/m/d h:i:s', time()) , 1));
    $usuarioDao->altaUsuario($user);
    $u = $usuarioDao->getLoginPassword($username, $password);
    if (!is_null($u)) {
        //Guardar datos de este usuario en la sessión
        $_SESSION['username'] = $u->getUsername();
        $_SESSION['profileImage'] = $u->getProfileImage();
        $_SESSION['ultimoAceso'] = $u->getAcceso()->getUltimoAcceso();
        $_SESSION['rol'] = $u->getAcceso()->getRol();
        mkdir('../galerias/'.$u->getUsername(), 700, true);

        header('Location: ../../index');
    }

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
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>

    <script type="text/javascript" rel="script" src="../../js/materialize.js"></script>
    <script type="text/javascript" rel="script" src="../../js/menu.js"></script>
    <script type="text/javascript" rel="script" src="../../js/singup.js"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<?php echo $template->navBar(null);?>
<div class="columnaMenu" id="colmenu">
    <?php echo $template->menu();?>
</div>
<div class="columnaMain" id="colmain">
    <div class="section no-pad-bot" id="index-banner">
        <div class="light-green lighten-4">
            <form method="post" action="Signup" name="singup" enctype="multipart/form-data">
            <div class="columnaMainLeft">
                <label  for="user_singup" class="text-lighten-2 col s4"><h6><strong id="user_singup_label">Username</strong></h6></label>
                <input id="user_singup" type="text" name="username" required/><br/>
                <label for="email_singup" class="text-lighten-2 col s4"><h6><strong id="email_singup_label">E-mail</strong></h6></label>
                <input id="email_singup" type="email" name="email" required/><br/>
                <label for="pass_singup" class="text-lighten-2 col s4"><h6><strong>Password</strong></h6></label>
                <input id="pass_singup" type="password" name="pass" required/><br/>
                <pre><label for="pass2_singup" class="text-lighten-2 col s4"><h6><strong id="pass2_singup_label">Repeat Password</strong></h6></label></pre>
                <input id="pass2_singup" type="password" name="password2" required/><br/>
                <div class="right-align"><button class="btn-large light-blue waves-effect waves-light right-aligned" id="submit_singup" type="submit" name="submit" value="singup" onclick="cifrar()" disabled>Sign Up</button></div>
            </div>
            <div class="columnaMainRight">
                <label for="name_singup" class="text-lighten-2 col s4"><h6><strong>Name</strong></h6></label>
                <input id="name_singup" type="text" name="name" required/><br/>
                <label for="lastname_singup" class="text-lighten-2 col s4"><h6><strong>Last Name</strong></h6></label>
                <input id="lastname_singup" type="text" name="lastname" required/><br/>
                <label for="birth_singup" class="text-lighten-2 col s4"><h6><strong id="birth_singup_label">Birth Date</strong></h6></label>
                <input id="birth_singup" type="date" name="birthdate" required/><br/>
                <div class="file-field input-field">
                    <div class="btn light-blue waves-effect waves-light">
                        <span>Profile image</span>
                        <input type="file" name="imagefile" id="id_image">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" id="image_singup" name="profileimage">
                    </div>
                </div>
                <h6 id="image_singup_label" class="red-text"></h6>
            </div>

            </form>
        </div>
    </div>
</div>
<?php echo $template->footer();?>

<script src="../../js/sha256.js"></script>
<script>
    function cifrar(){
        let input_pass = document.getElementById("pass_singup");
        input_pass.value = sha256(input_pass.value);
        let input_pass2 = document.getElementById("pass2_singup");
        input_pass2.value = sha256(input_pass2.value);
    }
</script>
</body>
</html>

