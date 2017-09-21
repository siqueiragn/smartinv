<?php

namespace core\componentes;

/**
 * A classe AutoCoplete permite que seja adicionado o componente de autocompletar em
 * inputs. Para isso a mesma utiliza a lib JS Typeahead do twitter.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package sistema.controlador.componentes
 * @version 1.0.0 21/11/2015
 */
class AutoComplete implements Componente{
    private static $adicionado = false;
    private static $cont = 0;
    private $id;
    private $lista = array();

    public function __construct($id){
        $this->id = $id;
    }
    
    public function setLista($lista){
        if(is_array($lista)){
            
        }else{
            throw new \ProgramacaoException('O argumento $lista deve ser uma lista');
        }
    }
    
    
    public function add() {
        if(!self::$adicionado){
            $this->view->addJquery();
            $this->view->addLibJavaScript('componentes/autoComplete/typeahead');
            $this->view->addLibJavaScript('componentes/autoComplete/autocomplete');
            $this->view->addLibCss('componentes/autoComplete/typeahead');
            self::$adicionado = true;
            $this->view->selfScript('var autoComplete = new Array();');
        }
        
        $this->view->selfScript('autoComplete['.self::$cont.'] = new Object();');
        $this->view->selfScript('autoComplete['.self::$cont.'].idCampo = "'.$this->id.'";');
        self::$cont++;
    }
}
