<?php
namespace core\libs\geo;
/**
 * Objeto que auxilia na criação de um GeoJson
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class GeoJson {

    private $geoJson;

    /**
     * Construtor da classe GeoJson 
     *
     */
    public function __construct() {
        $this->geoJson = array(
            'type' => 'FeatureCollection',
            'features' => array()
        );
    }

    public function encodaGeoJson($json, $dados = '', $epsg = '3857') {

        $feature = array(
            'type' => 'Feature',
            'geometry' => json_decode($json, true),
            'crs' => array(
                'type' => 'EPSG',
                'properties' => array('code' => $epsg)
            ),
            'properties' => $dados
        );

       
        array_push($this->geoJson['features'], $feature);
    }
    
    public function arrayToFeature($array, $dados = '', $epsg = '3857') {

        $feature = array(
            'type' => 'Feature',
            'geometry' => $array,
            'crs' => array(
                'type' => 'EPSG',
                'properties' => array('code' => $epsg)
            ),
            'properties' => $dados
        );

       
        array_push($this->geoJson['features'], $feature);
    }

    public function getGeoJson() {
        return json_encode($this->geoJson);
    }

    public function __toString() {
        return $this->getGeoJson();
    }
    
    public function addPropriedade($propriedade, $valor){
        $this->geoJson[$propriedade] = valor;
    }

}

?>
