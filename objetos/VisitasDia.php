<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 04/06/2018
 * Time: 20:37
 */

class VisitasDia
{
    private $id;
    private $autor;
    private $visitas;
    private $fecha;

    /**
     * VisitasDia constructor.
     * @param $id
     * @param $autor
     * @param $visitas
     * @param $fecha
     */
    public function __construct($id, $autor, $visitas, $fecha)
    {
        $this->id = $id;
        $this->autor = $autor;
        $this->visitas = $visitas;
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
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getVisitas()
    {
        return $this->visitas;
    }

    /**
     * @param mixed $visitas
     */
    public function setVisitas($visitas): void
    {
        $this->visitas = $visitas;
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