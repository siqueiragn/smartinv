<?php

namespace core\controller;

/**
 * Description of ToolsTrait
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
trait ToolsTrait
{

    /**
     * Método que executa a tool gerador de CRUD.
     * 
     * Vale lembrar que o submodulo tools não for clonado esse método não tem serventia.[
     */
     public function tool(){
        if(isset($GLOBALS['ARGS']['0']) && !empty($GLOBALS['ARGS']['0'])){
            $this->carregaTool($GLOBALS['ARGS']['0']);
        }else{
            $this->view->setRenderizado();
            echo 'tool Inexistente';            
        }
    }

    private function carregaTool($class)
    {
        if (DEBUG) {
            $this->view->setRenderizado();
            require_once(CORE . '../tools/' . $class . '.class.php');
            new $class();
        } else {
            $this->paginaNaoEncontrada();
        }
    }

}
