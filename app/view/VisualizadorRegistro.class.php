<?php

/**
 * Description of VisualizadorRegistro
 *
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0
 * @package
 */
class VisualizadorRegistro extends AbstractView
{
	
	private $mostrarNavegacao = true;
	
	public function __construct()
	{
		parent::__construct();
		$this->addTemplate('menuLogin');
		$this->addTemplate('cadastrar');
		$this->CDN()->add('jquery');
		$this->CDN()->add('bootstrap');
		$this->addCSS("custom");
		$this->attValue('navegacaoMenu', $this->mostrarNavegacao);
	}
	
	public function naoMostrarNavegacao()
	{
		$this->attValue('navegacaoMenu', false);
	}
	
}

