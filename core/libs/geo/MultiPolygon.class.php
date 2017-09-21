<?php


/**
 * Classe que modela um Multipoligono geográfico.
 * 
 * Possui os métodos para fazer a manipulação transparente entre um banco de dados
 * PostgreSQL que utilize o postigis >1.5. 
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 * @package sistema.controlador.libs.geo
 */
class MultiPolygon extends GeoType {
    //put your code here
    private $cordinates;
    
    public function __construct($cordinates) {
        $this->cordinates = $cordinates;
    }

    public function codigoInsercao() {
        return "ST_GeomFromGeoJSON('{
               \"type\":\"MultiPolygon\",
               \"coordinates\":" .$this->cordinates. ",
            \"crs\":{\"type\":\"name\",\"properties\":{\"name\":\"EPSG:" . $this->srid. "\"}}
            }')";
    }
}
