<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 26/05/2018
 * Time: 16:54
 */

require_once 'Conexion.php';

class SubsDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonSubs() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getSubsByUser($name)
    {

        try {
            $consulta = "SELECT user.id, user.username, user.profile_image FROM subs 
                    LEFT JOIN usuarios ON subs.id_user = usuarios.id 
					LEFT JOIN usuarios as user ON subs.id_autor = user.id
                    WHERE usuarios.username = '" . $name . "'";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getSubsByUser";
        }
        foreach ($lSubs as $clave => $valor){
            $arraySubs[$clave] = new Usuario($valor[0], $valor[1], null, null, null, null, $valor[2], null, null);
        }
        return $arraySubs;
    }

    public function getSubsByAutor($name)
    {

        try {
            $consulta = "SELECT user.id, user.username, user.profile_image FROM subs 
                    LEFT JOIN usuarios ON subs.id_autor = usuarios.id 
					LEFT JOIN usuarios as user ON subs.id_user = user.id
                    WHERE usuarios.username = '" . $name . "'";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getSubsByAutor";
        }
        $arraySubs = null;
        foreach ($lSubs as $clave => $valor){
            $arraySubs[$clave] = new Usuario($valor[0], $valor[1], null, null, null, null, $valor[2], null, null);
        }
        return $arraySubs;
    }

    public function getLastSubsByAutor($username)
    {

        try {
            $consulta="SELECT subs.id, id_user, id_autor, tipo FROM subs LEFT JOIN usuarios ON subs.id_autor = usuarios.id 
                          WHERE usuarios.username = '" . $username . "'  LIMIT 5";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getLastSubsByAutor";
        }
        $arraySubs = null;
        foreach ($lSubs as $clave => $valor){
            $arraySubs[$clave] = new Subs($valor[0], $valor[1], $valor[2], $valor[3]);
        }
        return $arraySubs;
    }

    public function getLastAutorBySub($username)
    {

        try {
            $consulta = "SELECT subs.id, id_user, id_autor, tipo FROM subs LEFT JOIN usuarios ON subs.id_user = usuarios.id 
                          WHERE usuarios.username = '" . $username . "'  LIMIT 5";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getLastAutorBySub";
        }
        $arraySubs = null;
        foreach ($lSubs as $clave => $valor){
            $arraySubs[$clave] = new Subs($valor[0], $valor[1], $valor[2], $valor[3]);
        }
        return $arraySubs;
    }

    public function getSubByUserAndAutor($userId, $autorId)
    {
        try {
            $consulta="SELECT id, id_user, id_autor, tipo FROM subs WHERE id_user = ". $userId ." AND id_autor = " . $autorId;

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getSubByUserAndAutor";
        }
        if(empty($lSubs)){
            $sub = null;
        }else {
            $sub = new Subs($lSubs[0][0], $lSubs[0][1], $lSubs[0][2], $lSubs[0][3]);
        }
        return $sub;
    }

    public function getSubTipo($userId, $autorId)
    {
        try {
            $consulta="SELECT tipo FROM subs WHERE id_user = ". $userId ." AND id_autor = " . $autorId;

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getSubByUserAndAutor";
        }
        if(empty($lSubs[0][0])){
            $lSubs[0][0] = 0;
        }

        return $lSubs[0][0];
    }

    public function countSubsByAutor($autorId)
    {

        try {
            $consulta="SELECT count(*) FROM subs WHERE id_autor = " . $autorId;

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en countSubsByAutor";
        }

        return $lSubs[0][0];
    }

    public function addSub($userId, $autorId, $tipo){
        try {
            $consulta="INSERT INTO subs (id, id_user, id_autor, tipo) values (null,?,?,?)";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$userId);
            @$query->bindParam(2,$autorId);
            @$query->bindParam(3,$tipo);

            $query->execute();
            $insertado=true;

        } catch (Exception $ex) {
            $insertado=false;
        }
        return  $insertado;
    }

    public function updateSub($userId, $autorId, $tipo){
        try {
            $consulta="UPDATE subs SET tipo = ? WHERE id_user = ? AND id_autor = ?";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(2,$userId);
            @$query->bindParam(3,$autorId);
            @$query->bindParam(1,$tipo);
            $query->execute();
            $insertado=true;

        } catch (Exception $ex) {
            $insertado=false;
        }
        return  $insertado;
    }

    public function unSub($userId, $autorId){
        try {
            $consulta="DELETE FROM subs WHERE id_user = ? AND id_autor = ?";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$userId);
            @$query->bindParam(2,$autorId);

            $query->execute();
            $eliminado=true;

        } catch (Exception $ex) {
            $eliminado=false;
        }
        return  $eliminado;
    }

}