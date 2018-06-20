<?php

namespace Usuario\Model\Dao;


use Usuario\Model\Entity\Usuario;
use Usuario\Model\Dao\IUsuarioDao;

use Zend\Db\TableGateway\TableGateway;

use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

use RuntimeException;

/**
 * Description of UsuarioDao
 *
 * @author Andres
 */
class UsuarioDao implements IUsuarioDao{

    //private $listaUsuario;
    private $tableGateway;
    
   function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;	
    }

    function obtenerTodos() {
        //return $this->listaUsuario;
        /*
         * $resultSet = $this->tableGateway->select();
         
        return $resultSet;
        */
        $select = $this->tableGateway->getSql()->select();
        $dbAdapter = $this->tableGateway->getAdapter();
        $resultSetPrototype = $this->tableGateway->getResultSetPrototype();
        $adapter = new DbSelect($select, $dbAdapter, $resultSetPrototype);
        $paginator = new Paginator($adapter);
        
        return $paginator;
        
    }
    function obtenerPorId($id) {
        $rowset = $this->tableGateway->select(['idUsuario' => (int)$id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("No se pudo encontrar el Usuario: $id");
        }
        return $row;
    }

    function buscarPorNombre($nombre) {
		
		$resultado = null;
        
        foreach($this->listaUsuario as $usuario){
            
            if(($usuario->getNombre() == $nombre) || ($usuario->getApellido() == $nombre)){
                
                $resultado = $usuario;
                break; 
            }
        }
        return $resultado;
    }

    function eliminar(Usuario $usuario) {
        $this->tableGateway->delete(['idUsuario' => $usuario->getId()]);
    }
    
    function guardar(Usuario $usuario) {
     
       $data = [
            'nbUsuario' => $usuario->getNombre(),
            'appUsuario' => $usuario->getApellido(),
            'mailUsuario' => $usuario->getCorreo(),
            'nbUsuario' => $usuario->getUserName(),
            'passUsuario' => $usuario->getPassword()
            ,];
       
        //var_dump($usuario);
        
        $id = (int) $usuario->getId();
        
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } 
        else 
        {
            if ($this->obtenerPorId($id)) {
                var_dump($data,true);
                exit();
                $this->tableGateway->update($data, [
                                    'idUsuario' => $id]);
            } 
            else 
            {
                throw new RuntimeException('Id del usuario no existe');
            }
        }
    }

}
