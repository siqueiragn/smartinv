<?php

/**
 * Description of PointClusterLayer
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class PointClusterLayer extends core\componentes\mapa\layers\Layer
{
    private $dimensoes;
    
    public function __construct($label, $icone)
    {
        $this->label = $label;
        $this->icone = $icone;
    }
    
    public function __toString() {
        $codigo = '';
    
        $gerador = 'geradorIcone.php?icon='. $this->getIcone() . '&tom=' . $this->getTom()
                   . '&tam';
        $codigo .= " var pontosTmp = map.adicionaCamadaPontoJson(
                map.caminho.getExecutor() + 'consulta/getPontos?idCategoria=" . $this->getIdCategoria(). "',
                map.caminho.base + '$gerador=0'
                );
                

        var i". self::$i." = new ItemLegenda('" . $this->getLabel() . "', pontosTmp);
        i". self::$i.".cluster = true;
        i". self::$i.'.nomeIcone = "' .$this->getIcone(). '";'.
        "i". self::$i.".fonteDeDados = map.caminho.getExecutor() + 'consulta/getPontos?idCategoria=" . $this->getIdCategoria(). "';    
        i". self::$i.".icone = map.caminho.base + '$gerador=0';";
       // i". self::$i.".dim = " . $this->dimensoesVariavel . ";
        $codigo .= " i". self::$i.".geradorIcone = new Array();";
        for($i = 0; $i < $this->qtdTam; $i++){
            $codigo .= "i". self::$i.".geradorIcone[$i] = map.caminho.base + "
                    . "'$gerador=$i';" . PHP_EOL;
        }
        $codigo .= 'map.adicionaItemLegenda(i' . self::$i. ');';
        
        self::$i++;
        return $codigo;
    }
    
}
