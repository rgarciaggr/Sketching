<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:38
 */

class Acceso
{
    private $idUsuario;
    private $password;
    private $ultimoAcceso;
    private $rol;

    /**
     * Acceso constructor.
     * @param $idUsuario
     * @param $password
     * @param $ultimoAcceso
     * @param $rol
     */
    public function __construct($idUsuario, $password, $ultimoAcceso, $rol)
    {
        $this->idUsuario = $idUsuario;
        $this->password = $password;
        $this->ultimoAcceso = $ultimoAcceso;
        $this->rol = $rol;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUltimoAcceso()
    {
        return $this->ultimoAcceso;
    }

    /**
     * @param mixed $ultimoAcceso
     */
    public function setUltimoAcceso($ultimoAcceso): void
    {
        $this->ultimoAcceso = $ultimoAcceso;
    }

    /**
     * @return mixed
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param mixed $rol
     */
    public function setRol($rol): void
    {
        $this->rol = $rol;
    }


}