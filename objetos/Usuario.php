<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 07/05/2018
 * Time: 21:33
 */

class Usuario{


    private $id;
    private $username;
    private $email;
    private $nombre;
    private $appelido;
    private $birthDate;
    private $acceso;
    private $profile_image;
    private $descripcion;

    /**
     * Usuario constructor.
     * @param $id
     * @param $username
     * @param $email
     * @param $nombre
     * @param $appelido
     * @param $birthDate
     * @param $acceso
     * @param $profile_image
     * @param $descripcion
     */
    public function __construct($id, $username, $email, $nombre, $appelido, $birthDate, $profile_image, $descripcion, $acceso)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->appelido = $appelido;
        $this->birthDate = $birthDate;
        $this->acceso = $acceso;
        $this->profile_image = $profile_image;
        $this->descripcion = $descripcion;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function getAppelido()
    {
        return $this->appelido;
    }

    /**
     * @param mixed $appelido
     */
    public function setAppelido($appelido): void
    {
        $this->appelido = $appelido;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getAcceso()
    {
        return $this->acceso;
    }

    /**
     * @param mixed $acceso
     */
    public function setAcceso($acceso): void
    {
        $this->acceso = $acceso;
    }

    /**
     * @return mixed
     */
    public function getProfileImage()
    {
        return $this->profile_image;
    }

    /**
     * @param mixed $profile_image
     */
    public function setProfileImage($profile_image): void
    {
        $this->profile_image = $profile_image;
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


}