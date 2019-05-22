<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/7/2018
 * Time: 7:22 AM
 */


require_once '../functions/Factory.php';
require_once '../controller/SexoCtr.php';
class UtilizadorMDL{

    private $iduser;
    private $fullname;
    private $idsexo;
    private $idprevilegio;
    private $username;
    private $password;
    private $data_registo;

    function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getIdsexo()
    {
        return $this->idsexo;
    }

    /**
     * @param mixed $idsexo
     */
    public function setIdsexo($idsexo)
    {
        $this->idsexo = $idsexo;
    }

    /**
     * @return mixed
     */
    public function getIdprevilegio()
    {
        return $this->idprevilegio;
    }

    /**
     * @param mixed $idprevilegio
     */
    public function setIdprevilegio($idprevilegio)
    {
        $this->idprevilegio = $idprevilegio;
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
    public function setUsername($username)
    {
        $this->username = $username;
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
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDataRegisto()
    {
        return $this->data_registo;
    }

    /**
     * @param mixed $data_registo
     */
    public function setDataRegisto($data_registo)
    {
        $this->data_registo = $data_registo;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    function __unset($name)
    {
        // TODO: Implement __unset() method.
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return "";
    }

    function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    function __clone()
    {
        // TODO: Implement __clone() method.
    }


}