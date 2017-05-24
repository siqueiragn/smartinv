<?php


/**
 * Description of AbstractController
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package core.controller 
 */
abstract class AbstractController {
    use \core\controller\StorageTrait;
    use \core\controller\ToolsTrait;
    /**
     *
     * @var AbstractView  
     */
    protected $view;
    
    public abstract function index();
    
    public abstract function paginaNaoEncontrada();


    public function redirect($url){
        #TODO Testa se foi enviado alguma coisa senão redireciona.
        header('Location: '. $url);
    }
    
    
    protected function getArg($pos, $tipo = FILTER_SANITIZE_STRING){
        return filter_var($GLOBALS['ARGS'][$pos], $tipo);
    }


    /**
     * Método que recebe um array e trata os dados o método é recursivo caso receba um 
     * array.
     * 
     * @param Array $array
     * @return Array
     */
    public function trataArrayDados($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)){ 
                $array[$key] = $this->trataArrayDados($value);                
            }else if (is_int($value)){ 
                $array[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT); 
            } else if (is_float($value)){ 
                $array[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            } else if (is_string($value)){ 
                $array[$key] = filter_var($value, FILTER_SANITIZE_STRING);                 
            } else {
                $array[$key] = filter_var($value, FILTER_DEFAULT); continue;
            }
        }        
        return $array;
    }

     
    public function __destruct() {
        if(isset($this->view) && !$this->view->isRender()){
            $this->view->render();
        }
    }
}
