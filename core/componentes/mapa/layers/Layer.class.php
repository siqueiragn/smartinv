<?php

namespace core\componentes\mapa\layers;

/**
 * Description of Layer
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
abstract class Layer
{

    protected static $i = 0;
    protected $label;
    protected $icone;
    protected $varMapa = 'mapa1';
    protected $visivel = false;
    /**
     *
     * @var Legenda 
     */
    protected $legenda = null;


    public function setLegenda(\Legenda $l){
        $this->legenda = $l;
    }
    

    /**
     * Método que retorna o valor da variável label
     *
     * @return String - Valor da variável label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Método que seta o valor da variável label
     *
     * @param String $label - Valor da variável label
     */
    public function setLabel($label)
    {
        $label = trim($label);
        $this->label = $label;
        return true;
    }

    /**
     * Método que retorna o valor da variável icone
     *
     * @return String - Valor da variável icone
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Método que seta o valor da variável icone
     *
     * @param String $icone - Valor da variável icone
     */
    public function setIcone($icone)
    {
        $icone = trim($icone);
        $this->icone = $icone;
        return true;
    }
    
    public function geraVisibilidade(){
        $visibilidade = $this->visivel ? 'true;' : 'false;';
        return 'item.checked = ' . $visibilidade;
    }

}
