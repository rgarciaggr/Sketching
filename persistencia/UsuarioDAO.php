<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:37
 */

require_once 'Conexion.php';

class UsuarioDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonUsuario() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getTodosUsuarios()
    {

        try {
            $consulta="SELECT id, username, email, nombre, apellido, birth_date, profile_image, descripcion FROM usuarios";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lUsuarios=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getListaUsuarios";
        }
        foreach ($lUsuarios as $clave => $valor){
            $arrayUsuarios[$clave] = new Usuario($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5], $valor[6], $valor[7], null);
        }
        return $arrayUsuarios;
    }

    public function getBusquedaUsuarios($busqueda)
    {

        try {
            $consulta="SELECT id, username, email, nombre, apellido, birth_date, profile_image, descripcion FROM usuarios WHERE username LIKE '%". $busqueda ."%';";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lUsuarios=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getListaUsuarios";
        }
        $arrayUsuarios = null;
        foreach ($lUsuarios as $clave => $valor){
            $arrayUsuarios[$clave] = new Usuario($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5], $valor[6], $valor[7], null);
        }
        return $arrayUsuarios;
    }

    public function getBusquedaAutocomp($busqueda)
    {

        try {
            $consulta="SELECT username, profile_image FROM usuarios WHERE username LIKE '%". $busqueda ."%';";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lUsuarios=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getBusquedaAutocomp";
        }
        return $lUsuarios;
    }

    public function getTopFive(){
        try {
            $consulta="SELECT username, profile_image, SUM(galeria.visitas) FROM usuarios
                      LEFT JOIN galeria ON usuarios.id = galeria.autor 
                      GROUP BY autor ORDER BY SUM(galeria.visitas) DESC LIMIT 5" ;
            $query=$this->db->preparar($consulta);
            $query->execute();
            $count=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getTopFive";
            $count = 0;
        }


        return $count;
    }
    
    public function getUserByName($userName)
    {
        try {
            $consulta="SELECT id, username, email, nombre, apellido, birth_date, profile_image, descripcion FROM usuarios WHERE username='" .$userName ."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $tUsuarios=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en getUnUsuario";
        }
        if (empty($tUsuarios)){
            $u=null;
        }
        else{

            $u=new Usuario($tUsuarios[0][0], $tUsuarios[0][1], $tUsuarios[0][2], $tUsuarios[0][3], $tUsuarios[0][4], $tUsuarios[0][5], $tUsuarios[0][6], $tUsuarios[0][7],null);
        }
        return $u;
    }

    public function getIdByName($userName)
    {
        try {
            $consulta="SELECT id FROM usuarios WHERE username='" .$userName ."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $tUsuarios=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en getUnUsuario";
        }
        if (empty($tUsuarios)){
            $u=null;
        }
        else{

            $u=$tUsuarios[0][0];
        }
        return $u;
    }

    public function getUsuario($numUsuario)
    {
        try {
            $consulta="SELECT id, username, email, nombre, apellido, birth_date, profile_image, descripcion FROM usuarios WHERE id=" .$numUsuario;
            $query=$this->db->preparar($consulta);
            $query->execute();
            $tUsuarios=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en getUnUsuario";
        }
        if (empty($tUsuarios)){
            $u=null;
        }
        else{

            $u=new Usuario($tUsuarios[0][0], $tUsuarios[0][1], $tUsuarios[0][2], $tUsuarios[0][3], $tUsuarios[0][4], $tUsuarios[0][5], $tUsuarios[0][6], $tUsuarios[0][7], null);
        }
        return $u;
    }

    public function getUsuarioExiste($usuario)
    {
        try {
            $consulta="SELECT username FROM usuarios WHERE username='" .$usuario."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $tUsuarios=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en get UsuarioExiste";
        }
        if (empty($tUsuarios)){
            $u=false;
        }
        else{
            $u=true;
        }
        return $u;
    }

    public function getEmailExiste($parametro)
    {
        try {
            $consulta="SELECT email FROM usuarios WHERE email='" .$parametro."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $tUsuarios=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en getEmailExiste";
        }
        if (empty($tUsuarios)){
            $u=false;
        }
        else{
            $u=true;
        }
        return $u;
    }

    public function getLoginPassword($username, $password)
    {
        try {
            $consulta="SELECT id, username, email, nombre, apellido, birth_date, profile_image, descripcion FROM usuarios WHERE username='" . $username . "'";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $aUsuario=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getLoginPassword";
        }
        if (empty($aUsuario)){
            $u=NULL;
        } else {
            try {
                $consulta1 = "SELECT id_usuario, password, ultimo_acceso, rol FROM acceso WHERE id_usuario=" . $aUsuario[0][0] . " and password='" . $password . "'";
                $query1 = $this->db->preparar($consulta1);
                $query1->execute();
                $aAcceso = $query1->fetchAll();

            } catch (Exception $ex) {
                echo "Se ha producido un error en getLoginPassword";
            }
            if (empty($aAcceso)) {
                $a = null;
                $u = null;
            } else {
                $a = new Acceso($aAcceso[0][0], null, $aAcceso[0][2], $aAcceso[0][3]);
                $u = new Usuario($aUsuario[0][0], $aUsuario[0][1], $aUsuario[0][2], $aUsuario[0][3], $aUsuario[0][4], $aUsuario[0][5],  $aUsuario[0][6], $aUsuario[0][7], $a);

            }
        }
        return $u;
    }

    public function countUsers(){
        try {
            $consulta="SELECT COUNT(*) FROM usuarios" ;
            $query=$this->db->preparar($consulta);
            $query->execute();
            $count=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en addvisita";
            $count[0][0] = 0;
        }

        return $count[0][0];
    }

    public function getUserRol($id)
    {
        try {
            $consulta = "SELECT rol FROM acceso WHERE id_usuario=" . $id;
            $query = $this->db->preparar($consulta);
            $query->execute();
            $rol = $query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getUserRol";
        }
        return $rol[0][0];
    }

    public function updateRol($id, $newRol)
    {
        try {
            $consulta = "UPDATE acceso SET rol = ? WHERE id_usuario = ?";
            $query = $this->db->preparar($consulta);
            @$query->bindParam(1,$newRol);
            @$query->bindParam(2,$id);
            $query->execute();
            $rol = $query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en updateRol";
        }
        return $rol;
    }

    public function altaUsuario(Usuario $u)
    {
        try {
            $consulta="INSERT INTO usuarios (id, username, email, nombre, apellido, birth_date, profile_image) values (null,?,?,?,?,?,?)";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$u->getUsername());
            @$query->bindParam(2,$u->getEmail());
            @$query->bindParam(3,$u->getNombre());
            @$query->bindParam(4,$u->getAppelido());
            @$query->bindParam(5,$u->getBirthDate());
            @$query->bindParam(6,$u->getProfileImage());

            $query->execute();
            try {
                $consulta="SELECT id FROM usuarios WHERE username='". $u->getUsername() ."'";
                $query=$this->db->preparar($consulta);
                $query->execute();
                $idUser = $query->fetchAll();

                $consulta="INSERT INTO acceso (id_usuario,password,ultimo_acceso,rol) values (?,?,?,?)";

                $query=$this->db->preparar($consulta);
                @$query->bindParam(1,$idUser[0][0]);
                @$query->bindParam(2,$u->getAcceso()->getPassword());
                @$query->bindParam(3,$u->getAcceso()->getUltimoAcceso());
                @$query->bindParam(4,$u->getAcceso()->getRol());

                $query->execute();
                $insertado=true;

            } catch (Exception $ex) {
                $insertado=false;
            }

        } catch (Exception $ex) {
            $insertado=false;
        }
        return  $insertado;
    }

    public function actualizarUsuario(Usuario $u, $username){
        try{
            $consulta="UPDATE usuarios SET username = ?, email = ?, nombre  = ?, apellido = ?, birth_date = ?, profile_image = ?, descripcion = ? WHERE username = '".$username."'";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$u->getUsername());
            @$query->bindParam(2,$u->getEmail());
            @$query->bindParam(3,$u->getNombre());
            @$query->bindParam(4,$u->getAppelido());
            @$query->bindParam(5,$u->getBirthDate());
            @$query->bindParam(6,$u->getProfileImage());
            @$query->bindParam(7,$u->getDescripcion());

            $query->execute();
            $actualizado=true;

        } catch (Exception $ex) {
            $actualizado=false;
        }

        return $actualizado;
    }

    public function borrarUsuario($username){
        try{
            $consulta="DELETE FROM usuarios WHERE username = '".$username."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $borrado=true;

        } catch (Exception $ex) {
            $borrado=false;
        }

        return $borrado;
    }

}