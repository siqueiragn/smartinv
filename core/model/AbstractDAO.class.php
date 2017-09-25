<?php

/**
 * Description of AbstractDAO
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
abstract class AbstractDAO extends AbstractModel
{

    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function save(DTOInterface $object)
    {
        $id = $object->getID();
        if(empty($id)){
            return $this->create($object);
        }else{
            return $this->update($object);
        }
    }

    /**
     * Método que insere um objeto em sua respectiva tabela no banco de dados
     *
     * @param DTOInterface Objeto data transfer
     */
    public function create(DTOInterface $object)
    {
        return $this->db->insert($object->getTable(), $object->getArrayDados());
    }

    public function getOne(DTOInterface $object)
    {
        return $this->getByID($object->getID());
    }
    
    /**
     * 
     * @param type $condicao
     * @return DTOInterface
     */
    public function getOneByCondition($condicao){
        $lista = $this->getLista($condicao);
        if($lista){
            #TODO issue #17 - Verificar a performance de logar se caso retornou mais de um resultado.
            return $lista[0];
        }
        return false;
    }


    /**
     * 
     * @param Misc $id
     */
    public abstract function getByID($id);
    
    /**
     * 
     * @param Misc $condicao
     */
    public abstract function getLista($condicao);
    
    public function getMapa($coluna, DTOInterface $object){
        return $this->getMapaSimplesDados($this->queryTable($object->getTable()), $object->getID(), $coluna);
    }
    
   /**
     * @return Array  Objetos 
     */
    public function getAll()
    {
        return $this->getLista(false);
    }

    public function update(DTOInterface $object)
    {
        return $this->db->update($object->getTable(), $object->getArrayAtualizar(), $object->getCondition());
    }

    /**
     * Remove o objeto do banco de dados
     * 
     * @param DTOInterface $object
     * @return boolean
     */
    public function delete(DTOInterface $object)
    {
        return $this->db->delete($object->getTable(), $object->getCondition());
    }

    /**
     * 
     */
    private function isValid()
    {
        
    }

}
