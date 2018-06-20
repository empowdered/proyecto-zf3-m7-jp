<?php

namespace Usuario\Model\Dao;
use Usuario\Model\Entity\Usuario;

interface IUsuarioDao{
    
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Usuario $usuario);
    public function eliminar(Usuario $usuario);
    
}