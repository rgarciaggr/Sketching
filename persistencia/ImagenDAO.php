<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 05/06/2018
 * Time: 0:05
 */

require_once 'Conexion.php';

class ImagenDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonImagen() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function addImagen($imagen){
        try{
            $consulta="INSERT INTO imagen (nombre, link, fecha_subida, id_galeria) values (?,?,?,?)";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$imagen->getNombre());
            @$query->bindParam(2,$imagen->getLink());
            @$query->bindParam(3,$imagen->getFechaSubida());
            @$query->bindParam(4,$imagen->getIdGaleria());
            var_dump($query);
            $result = $query->execute();

        }catch (Exception $ex){
            echo "Se ha producido un error en addImagen";
            $result = false;
        }
        var_dump($result);
        return $result;
    }

    public function getImagenesByGaleria($idGaleria)
    {
        try {
            $consulta="SELECT id, nombre, link, fecha_subida, id_galeria FROM imagen WHERE id_galeria = " . $idGaleria;
            $query=$this->db->preparar($consulta);
            $query->execute();
            $lGalerias=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getImagenesByGaleria";
        }

        $arrayUsuarios = null;
        foreach ($lGalerias as $clave => $valor){
            $arrayGalerias[$clave] = new Imagen($valor[0], $valor[1], $valor[2], $valor[3], $valor[4]);
        }
        return $arrayGalerias;
    }

    public function borrarImagenesGaleria($idGaleria){
        try {
            $consulta="DELETE FROM imagen WHERE id_galeria = " . $idGaleria;
            $query=$this->db->preparar($consulta);
            $result = $query->execute();

        } catch (Exception $ex) {
            echo "Se ha producido un error en borrarImagenesGaleria";
            $result = false;
        }
        return $result;
    }

}