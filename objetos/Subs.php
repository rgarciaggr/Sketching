<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 26/05/2018
 * Time: 16:54
 */

class Subs
{
    private $id;
    private $user;
    private $autor;
    private $tipo;

    /**
     * Subs constructor.
     * @param $id
     * @param $user
     * @param $autor
     * @param $tipo
     */
    public function __construct($id, $user, $autor, $tipo)
    {
        $this->id = $id;
        $this->user = $user;
        $this->autor = $autor;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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