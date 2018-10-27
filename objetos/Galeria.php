<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:40
 */

class Galeria
{
    private $id;
    private $nombre;
    private $descripcion;
    private $autor;
    private $fechaCreacion;
    private $visitas;
    private $tipo;

    /**
     * Galeria constructor.
     * @param $id
     * @param $nombre
     * @param $descripcion
     * @param $autor
     * @param $fechaCreacion
     * @param $visitas
     * @param $tipo
     */
    public function __construct($id, $nombre, $descripcion, $autor, $fechaCreacion, $visitas, $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->autor = $autor;
        $this->fechaCreacion = $fechaCreacion;
        $this->visitas = $visitas;
        $this->tipo = $tipo;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
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
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param mixed $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }


}