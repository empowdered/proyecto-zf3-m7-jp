<?php

namespace Usuario\Model\Entity;

class Usuario {

    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $username;
    private $password;
	
    function __construct(){
        
    }
    
    public function getId() {
        return $this->id;
    }
    function setId($id){
       $this->id = $id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    function setApellido($apellido){
        $this->apellido = $apellido;
    }
    function getCorreo(){
        return $this->correo;
    }
    function setCorreo($correo){
        $this->correo = $correo;
    }
    function getUserName(){
            return $this->username;
    }
    function setUserName($username){
        $this->username = $username;
    }

    function getPassword(){
            return $this->password;
    }
    function setPassword($password){
        $this->password = $password;
    }
    public function exchangeArray($data) 
    {
        $this->setId((isset($data['idUsuario'])) ? $data['idUsuario'] : null);
        $this->setNombre((isset($data['nbUsuario'])) ? $data['nbUsuario'] : null);
        $this->setApellido((isset($data['appUsuario'])) ? $data['appUsuario'] : null);
        $this->setCorreo((isset($data['mailUsuario'])) ? $data['mailUsuario'] : null);
        $this->setUserName((isset($data['nickUsuario'])) ? $data['nickUsuario'] : null);
        $this->setPassword((isset($data['passUsuario'])) ? $data['passUsuario'] : null);
    }
    public function exchangeArray2($data)
    {
        $this->setId((isset($data['id'])) ? $data['id'] : null);
        $this->setNombre((isset($data['nombre'])) ? $data['nombre'] : null);
        $this->setApellido((isset($data['apellido'])) ? $data['apellido'] : null);
        $this->setCorreo((isset($data['email'])) ? $data['email'] : null);
        $this->setUserName((isset($data['username'])) ? $data['username'] : null);
        $this->setPassword((isset($data['password'])) ? $data['password'] : null);
        
    }
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
