<?php

namespace core\model;

/**
 * A DTO Trait é uma trait que tem por função dar uma certa inteligência
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package core.c
 */
trait DTOTrait
{

    /**
     * Método responsável por retornar um array com o formato 
     *     "campo_tabela" => "valor" 
     * 
     * para inserir no banco
     * 
     * @return Array - Array de dados para inserir 
     */
    public function getArrayDados()
    {
        $campos = array();
        foreach ($this as $chave => $valor) {
            if ((  $this->verificaCampo($chave)) 
                    && ($chave != 'isValid') 
                    && ($chave != 'table')) {
                $campos[\StringUtil::underscoreNumber($chave)] = $valor;
            }
        }
        return $campos;
    }
    
    /**
     * Método responsável por retornar um array com o formato 
     *     "campo_tabela" => "valor" 
     * 
     * para atualizar tupla em uma tabela no banco
     * 
     * @return Array - Array de dados para atualizar 
     */
    public function getArrayAtualizar()
    {
        $campos = array();
        foreach ($this as $chave => $valor) {
            if ($this->verificaCampo($chave) && $valor !== null ) {
                $campos[\StringUtil::toUnderscore($chave)] = $valor;
            }
        }
        return $campos;
    }

    /**
     * Método responsável por popular o objeto recebendo um array no formato
     * "nomeCampo" => "valor" 
     *
     * @param Array $array - Array de 
     * @return Integer - número de erros encontrados
     */
    public function setArrayDados($array)
    {
        $erros = 0;
        foreach ($array as $campo => $valor) {
            $metodo = 'set' . ucfirst($campo);
            if (method_exists($this, $metodo) && !$this->{$metodo}($this->trataValor($valor))) {
                $erros ++;
                $this->isValid = false;
            }
        }
        return $erros;
    }
    
    public function load($tabela, $id){
        $daoName = \StringUtil::toCamelCase($tabela,1).'DAO';
        $dao = new $daoName();
        return $dao->getById($id);
    }
    
    public function loadList($tabela, $condicao){
        $daoName = \StringUtil::toCamelCase($tabela,1).'DAO';
        $dao = new $daoName();
        return $dao->getLista($condicao);
    }

    /**
     * Método que recebe os valores através de variável e caso necessário
     * faz o parser dos objetos.
     * 
     * @param misc $valor
     * @return misc pode ser o próprio valor ou um objeto.
     */
    private function trataValor($valor){
        if(is_string($valor) && strpos($valor, 'POINT(')!== false){
            return new \Point($valor);
        }
        return $valor;
    }
    
    private function verificaCampo($chave){
        return ((   strcasecmp($chave, 'id' . __CLASS__) != 0) 
                    && ($chave != 'isValid')
                    && ($chave != 'table')
                    && ($chave[0] != '_'));
            
        
    }
}
