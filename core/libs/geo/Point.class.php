<?php

/**
 * Classe que modela um Ponto geográfico.
 * 
 * Possui os métodos para fazer a manipulação transparente entre um banco de dados
 * PostgreSQL que utilize o postigis >1.5. 
 * 
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com> 
 * @version 2.0  2015-11-02  
 * @package sistema.controlador.libs.geo
 */
class Point extends GeoType{

    private $x;
    private $y;
 

    /**
     * 
     * @param type $x
     * @param type $y
     * @param type $srid
     */
    public function __construct($x, $y = false, $srid = 29182) {     
        if ($y === false) {
            $cor = str_replace('POINT(', '', $x);
            $cor = str_replace(')', '', $cor);
            list($x, $y) = explode(' ', $cor);
            if(abs($x) < 500){ //Detecção "automatica" de SRID
                $srid = 4326;
            }
        }
        $this->setX($x);
        $this->setY($y);
        $this->srid = $srid;
    }

    /**
     * Método que retorna a coordenada do ponto.
     * 
     * @return float - Coordenada x do ponto
     */
    public function getX() {
        return $this->x;
    }
    
    public function setX($x) {
        $x = str_replace(',', '.', $x);
        $this->x = $x;
    }

    public function getY() {
        return $this->y;
    }

    public function setY($y) {
        $y = str_replace(',', '.', $y);
        $this->y = $y;
    }
   
    /**
     * Alias para retorna XY
     * #TODO analizar onde se usa isso nos projetos para deixar apenas 1 função
     * 
     * @return 
     */
    public function retornaLatLon(){
        return $this->retornaXY();
    }

    /**
     * 
     * @return Array
     */
    public function retornaXY() {
        return array('lat' => $this->x, 'lon' => $this->y);
    }

    public function codigoInsercao() {
        if ($this->postigisVersion < 2) {
            return "ST_GeomFromText('" . $this . "'," . $this->getSrid() . ')';
        }
        return "ST_GeometryFromText('SRID=" . $this->getSrid() . ";" . $this . "')";
    }

    public function __toString() {
        return "POINT(" . $this->x . ' ' . $this->y . ")";
    }
    
}
