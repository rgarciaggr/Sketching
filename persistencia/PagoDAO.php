<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 02/06/2018
 * Time: 15:34
 */

require_once 'Conexion.php';

class PagoDAO
{
    private static $instancia;
    private $db;

    function __construct() {
        $this->db = Conexion::singleton_conexion();
    }

    public static function singletonPago() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function addPago($userId, $autorId, $estado, $cantidad){
        try {
            $consulta="INSERT INTO pagos (id, estado, emisor, destinatario, cantidad, fecha) values (null,?,?,?,?,null)";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$estado);
            @$query->bindParam(2,$userId);
            @$query->bindParam(3,$autorId);
            @$query->bindParam(4,$cantidad);

            $query->execute();
            $insertado=true;

        } catch (Exception $ex) {
            $insertado=false;
        }
        return  $insertado;
    }

    public function updatePago($id, $estado){
        try {
            $consulta="UPDATE pagos SET estado = ? WHERE id = ?";
            $query=$this->db->preparar($consulta);
            @$query->bindParam(1,$estado);
            @$query->bindParam(2,$id);

            $query->execute();
            $insertado=true;

        } catch (Exception $ex) {
            echo "Se ha producido un error en updatePago";
            $insertado=false;
        }
        return  $insertado;
    }

    public function getPagosByUser($userId, $date)
    {

        try {
            $consulta="SELECT id, estado, emisor, destinatario, cantidad, fecha FROM pagos WHERE emisor = " . $userId ." AND fecha like '".$date."%' ORDER BY fecha DESC";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lPago=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getPagosByUser";
        }

        $arrayPagos = null;
        foreach ($lPago as $clave => $valor){
            $arrayPagos[$clave] = new Pago($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5]);
        }
        return $arrayPagos;
    }

    public function getPagosByAutor($userId, $date)
    {

        try {
            $consulta="SELECT id, estado, emisor, destinatario, cantidad, fecha FROM pagos WHERE destinatario = " . $userId ." AND fecha like '".$date."%' ORDER BY fecha DESC";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lPago=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getPagosByAutor";
        }

        $arrayPagos = null;
        foreach ($lPago as $clave => $valor){
            $arrayPagos[$clave] = new Pago($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5]);
        }
        return $arrayPagos;
    }

    public function getPagosByUserAndAutor($userId, $autorId)
    {
        try {
            $consulta="SELECT id, estado, emisor, destinatario, cantidad, fecha FROM pagos WHERE emisor = ". $userId ." AND destinatario = " . $autorId;

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lSubs=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getPagosByUserAndAutor";
        }
        if(empty($lSubs)){
            $arrayPagos = null;
        }else {
            foreach ($lSubs as $clave => $valor){
                $arrayPagos[$clave] = new Pago($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5]);
            }
        }
        return $arrayPagos;
    }

    public function getPagosByDate($date)
    {

        try {
            $consulta="SELECT id, estado, emisor, destinatario, cantidad, fecha FROM pagos WHERE fecha like '".$date."%' ORDER BY fecha DESC";

            $query=$this->db->preparar($consulta);

            $query->execute();
            $lPago=$query->fetchAll();

        } catch (Exception $ex) {
            echo "Se ha producido un error en getPagosByAutor";
        }

        $arrayPagos = null;
        foreach ($lPago as $clave => $valor){
            $arrayPagos[$clave] = new Pago($valor[0], $valor[1], $valor[2], $valor[3], $valor[4], $valor[5]);
        }
        return $arrayPagos;
    }


}