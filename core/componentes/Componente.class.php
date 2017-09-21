<?php

/**
 * Interface que determina os métodos que um componente da interface gráfica deve
 * possuir
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package core.components
 */
abstract class Componente
{
    
    /**
     * @var \AbstractView
     */
    protected $view;
    protected static $components = array();
    protected static $i = 1;
    protected static $adicionado = false;


    /**
     * Método que adiciona o componente na tela.
     */
    public abstract function add();

    public function requisitaComponente($componente)
    {
        #TODO vinculado a ISSUE#4
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView(\AbstractView $view)
    {
        $this->view = $view;
        return $this;
    }

    public static function registraComponente($componente, $pathAdicional = '')
    {
        $path = CORE . 'componentes/' . $pathAdicional . '/' . $componente;
        self::$components[$componente] = $path;
    }

    public static function carregaComponente($componente)
    {
        if (!isset(self::$components[$componente])) {
            self::registraComponente($componente);
            //throw new Exception("Componente requisitado não registrado!", 1);
        }
        $loader = $GLOBALS['loader'];
        $loader->addClass($componente, self::$components[$componente]);
    }
    
    protected function addTemplate($template){
        $this->view->addTemplate(CORE . 'view/templates/componentes/' . $template, true);
    }
    
    protected function generateId(){
        return self::$i++;
    }

}
