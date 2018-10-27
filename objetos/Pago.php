<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:40
 */

class Pago
{
    private $id;
    private $estado;
    private $emisor;
    private $destinatario;
    private $cantidad;
    private $fecha;

    /**
     * Pago constructor.
     * @param $id
     * @param $estado
     * @param $emisor
     * @param $destinatario
     * @param $cantidad
     * @param $fecha
     */
    public function __construct($id, $estado, $emisor, $destinatario, $cantidad, $fecha)
    {
        $this->id = $id;
        $this->estado = $estado;
        $this->emisor = $emisor;
        $this->destinatario = $destinatario;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getEmisor()
    {
        return $this->emisor;
    }

    /**
     * @param mixed $emisor
     */
    public function setEmisor($emisor): void
    {
        $this->emisor = $emisor;
    }

    /**
     * @return mixed
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * @param mixed $destinatario
     */
    public function setDestinatario($destinatario): void
    {
        $this->destinatario = $destinatario;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

}