<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/06/2018
 * Time: 0:37
 */

class RedesSocialesDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonSociales() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function addRedes($id, $twitter, $instagram)
    {
        try {
            $consulta="INSERT INTO redes_sociales (id_usuario, twitter, instagram) values (?,?,?)";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1, $id);
            @$query->bindParam(2, $twitter);
            @$query->bindParam(3, $instagram);

            $insertado = $query->execute();

        } catch (Exception $ex) {
            $insertado=false;
        }
        return  $insertado;
    }

    public function actualizarRedes($id, $twitter, $instagram){
        try{
            $consulta="UPDATE redes_sociales SET twitter = ?, instagram  = ? WHERE id_usuario = ?";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1, $twitter);
            @$query->bindParam(2, $instagram);
            @$query->bindParam(3, $id);

            $actualizado = $query->execute();

        } catch (Exception $ex) {
            $actualizado=false;
        }

        return $actualizado;
    }

    public function getRedes($username){
        try {
            $consulta="SELECT twitter, instagram FROM redes_sociales 
                      LEFT JOIN usuarios ON redes_sociales.id_usuario = usuarios.id WHERE usuarios.username = '" .$username."'";
            $query=$this->db->preparar($consulta);
            $query->execute();
            $redes=$query->fetchAll();
        } catch (Exception $ex) {
            echo "Se ha producido un error en getUnUsuario";
        }
        if (empty($redes)){
            $redes=null;
        }
        return $redes[0];
    }

}