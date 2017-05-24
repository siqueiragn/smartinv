<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PoligonHeatLayer
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class PoligonHeatLayer extends core\componentes\mapa\layers\Layer
{

    private $corInicial;
    private $corFinal;

    public function __construct($label, $corInicial, $corFinal = false)
    {
        $this->label = $label;
        $this->cor = $corInicial;
    } 

    public function __toString()
    {  
        $codigo = $this->legenda .'                  
        heatLayer = ' . $this->varMapa . '.adicionaCamadaGeoJson("getLimitesUBS", "", '.$this->legenda->getFormatter().');
        item = new ItemLegenda("' . $this->getLabel() . '",  heatLayer);'
                . $this->geraVisibilidade() 
                . 'item.info = ' .$this->legenda->getVariavel().    ';' . PHP_EOL;
                
  
        $codigo .= $this->varMapa . '.adicionaItemLegenda(item);' . PHP_EOL;

        self::$i++;
        return $codigo;
    }

}
