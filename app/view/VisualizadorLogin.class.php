<?php

/**
 * Description of VisualizadorGeral
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class VisualizadorLogin extends AbstractView
{

    private $mostrarNavegacao = false;

    public function __construct()
    {
        parent::__construct();
        $this->addTemplate('menu');
        $this->CDN()->add('jquery');
        $this->CDN()->add('bootstrap');
        $this->attValue('navegacaoMenu', $this->mostrarNavegacao);
        $this->addCSS('bootstrap-theme');
        $this->addCSS('style-responsive');
        $this->addCSS('login');
        $this->addCSS('font-awesome.min');
        $this->addCSS('elegant-icons-style');
    }

    public function naoMostrarNavegacao()
    {
        $this->attValue('navegacaoMenu', false);
    }

}

