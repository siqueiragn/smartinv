<?php

namespace core\components;

/**
 * A classe AutoCoplete permite que seja adicionado o componente de autocompletar em
 * inputs. Para isso a mesma utiliza a lib JS Typeahead do twitter.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package sistema.controlador.componentes
 * @version 1.0.0 21/11/2015
 */
class HTMLEditor implements Componente{
    private static $adicionado = false;
    private static $cont = 0;
    private $id;

    public function __construct($id){
        $this->id = $id;
    }
    
    public function adicionaComponente(Visualizador $visualizador) {
        if(!self::$adicionado){
            $visualizador->addJquery();
            $visualizador->addLibJavaScript('componentes/autoComplete/typeahead');
            $visualizador->addLibJavaScript('componentes/autoComplete/autocomplete');
            $visualizador->addLibCss('componentes/autoComplete/typeahead');
            self::$adicionado = true;
            $visualizador->addScriptInterno('var autoComplete = new Array();');
        }
        
        $visualizador->addScriptInterno('autoComplete['.self::$cont.'] = new Object();');
        $visualizador->addScriptInterno('autoComplete['.self::$cont.'].idCampo = "'.$this->id.'";');
        self::$cont++;
    }
}
