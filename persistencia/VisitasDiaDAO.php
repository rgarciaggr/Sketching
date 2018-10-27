<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 04/06/2018
 * Time: 20:05
 */

require_once 'Conexion.php';

class VisitasDiaDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonVisitasDia() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function createDayByAutor($idAutor){
        try{
            $consulta="INSERT INTO visitas_dia (id, autor, visitas, fecha) VALUES (null, " . $idAutor . ", 1, CURDATE())" ;
            $query=$this->db->preparar($consulta);
            $insert = $query->execute();

        } catch (Exception $ex) {
            echo "Se ha producido un error en createDayByAutor";
            $insert = false;
        }
        return $insert;
    }

    public function addvisita($idAutor)
    {
        try {
            $consulta="UPDATE visitas_dia SET visitas = visitas + 1 WHERE autor = ".$idAutor . " AND fecha = CURDATE()" ;
            $query=$this->db->preparar($consulta);
            $rGaleria = $query->execute();

        } catch (Exception $ex) {
            echo "Se ha producido un error en addvisita";
            $rGaleria = false;
        }
        return $rGaleria;
    }

    public function existDayAutor($idAutor)
    {
        $count = null;
        try {
            $consulta = "SELECT visitas FROM visitas_dia WHERE autor = " . $idAutor . " AND fecha = CURDATE()";
            $query = $this->db->preparar($consulta);
            $query->execute();
            $count = $query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en existDayAutor";
        }
        return $count;
    }

    public function getVisitasByAutor($idAutor){
        $rVisitas = null;
        try {
            $consulta = "SELECT visitas, fecha FROM visitas_dia WHERE autor = " . $idAutor . " AND fecha >= ( CURDATE() - INTERVAL 7 DAY ) ORDER BY fecha DESC";
            $query = $this->db->preparar($consulta);
            $query->execute();
            $rVisitas = $query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getVisitasByAutor";
        }

        return $rVisitas;
    }

    public function getVisitasUltimaSemana(){
        $rVisitas = null;
        try {
            $consulta = "SELECT SUM(visitas) as visitas, fecha FROM visitas_dia WHERE fecha >= ( CURDATE() - INTERVAL 7 DAY ) GROUP BY fecha ORDER BY fecha DESC ";
            $query = $this->db->preparar($consulta);
            $query->execute();
            $rVisitas = $query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getVisitasUltimaSemana";
        }

        return $rVisitas;
    }

}