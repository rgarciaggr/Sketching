<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:39
 */

class Imagen
{
    private $id;
    private $nombre;
    private $link;
    private $fechaSubida;
    private $idGaleria;

    /**
     * Imagen constructor.
     * @param $id
     * @param $nombre
     * @param $link
     * @param $fechaSubida
     * @param $idGaleria
     */
    public function __construct($id, $nombre, $link, $fechaSubida, $idGaleria)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->link = $link;
        $this->fechaSubida = $fechaSubida;
        $this->idGaleria = $idGaleria;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getFechaSubida()
    {
        return $this->fechaSubida;
    }

    /**
     * @param mixed $fechaSubida
     */
    public function setFechaSubida($fechaSubida): void
    {
        $this->fechaSubida = $fechaSubida;
    }

    /**
     * @return mixed
     */
    public function getIdGaleria()
    {
        return $this->idGaleria;
    }

    /**
     * @param mixed $idGaleria
     */
    public function setIdGaleria($idGaleria): void
    {
        $this->idGaleria = $idGaleria;
    }




}