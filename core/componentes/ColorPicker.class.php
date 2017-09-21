<?php


/**
 * A classe ColorPicker permite que seja adicionado o componente de seleção de cor
 * em uma página.
 * 
 *
 * @author Marcio Bigolin - marcio.bigolin@ucs.br
 * @package controlador.componentes
 * @version 21/12/2013
 */
class ColorPicker extends Componente{
    private static $cont = 0;
    private $id;

    public function __construct($id){
        $this->id = $id;
    }
    
    public function add() {
        if(!self::$adicionado){
            $this->view->addLibJS('componentes/color_picker/main');
            $this->view->addLibCss('componentes/color_picker/colorpicker');
            self::$adicionado = true;
            $this->view->addSelfScript('var colorPickers = new Array();');
        }
        $this->view->addSelfScript('colorPickers['.self::$cont.'] = new Object();');
        $this->view->addSelfScript('colorPickers['.self::$cont.'].idCampo = "'.$this->id.'";');
        self::$cont++;
    }

}
