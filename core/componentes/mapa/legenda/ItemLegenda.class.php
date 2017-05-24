<?php

/**
 * Objeto que representa um item da legenda do mapa
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 2014-07-13 - 1.0.0
 */
class ItemLegenda {
    private $icone;
    private $cluster;
    private $fonteDados;
    private $geradorDeIcones;
    private $dimensoes;
    private $dimensoesVariavel;
    private $label;
    private $tom;
    private $qtdTam;
    private $idCategoria;
    private static $tonsPossiveis = array(  'red', 'blue', 'green', 'orange', 
                                            'pink', 'black' );
    private static $i = 0;

    public function __construct($label, $cluster = true){
        $this->cluster = $cluster;
        $this->label = $label;
        $this->dimensoes = $this->dimensoesVariavel =  'dimensoes';
        $this->qtdTam = 4;
        $this->tom = 'red';        
    }
    
    public function getTom() {
        return $this->tom;
    }

    public function setTom($tom) {
        if (is_integer($tom)) {
            $this->tom = self::$tonsPossiveis[$tom];
        } else {
            if (in_array($tom, self::$tonsPossiveis)) {
                $this->tom = $tom;
            } else {
                $this->tom = 'red';
            }
        }
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }
    
    public function getIcone() {
        return $this->icone;
    }
    public function getCluster() {
        return $this->cluster;
    }

    public function getClusterStr() {
        if($this->cluster){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getFonteDados() {
        return $this->fonteDados;
    }

    public function getGeradorDeIcones() {
        return $this->geradorDeIcones;
    }

    public function getDimensoes() {
        return $this->dimensoes;
    }
    
    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function setIcone($icone) {
        $this->icone = $icone;
    }

    public function setCluster($cluster) {
        $this->cluster = $cluster;
    }

    public function setFonteDados($fonteDados) {
        $this->fonteDados = $fonteDados;
    }

    public function setGeradorDeIcones($geradorDeIcones) {
        $this->geradorDeIcones = $geradorDeIcones;
    }

    public function setDimensoes($dimensoes) {
        $this->dimensoes = $dimensoes;
    }
        
    public function __toString() {
        $codigo = '';
        if(is_array($this->dimensoes)){
            
        }
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
        i". self::$i.".icone = map.caminho.base + '$gerador=0';
        i". self::$i.".dim = " . $this->dimensoesVariavel . ";
        i". self::$i.".geradorIcone = new Array();";
        for($i = 0; $i < $this->qtdTam; $i++){
            $codigo .= "i". self::$i.".geradorIcone[$i] = map.caminho.base + "
                    . "'$gerador=$i';" . PHP_EOL;
        }
        $codigo .= 'map.adicionaItemLegenda(i' . self::$i. ');';
        
        self::$i++;
        return $codigo;
    }
    
    private static function tonsPossiveis(){
        
    }
}
