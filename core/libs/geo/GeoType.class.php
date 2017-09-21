<?php

/**
 * Classe abstrata que determina os métodos necessários para a contrução de objetos 
 * geográficos.
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
abstract class GeoType implements \core\model\io\ObjetoInsercao
{

    protected $postigisVersion = 1.5;
    protected $srid = 4326;

    public function getPostigisVersion()
    {

        return $this->postigisVersion;
    }

    public function setPostigisVersion($postigisVersion)
    {
        $this->postigisVersion = $postigisVersion;
    }

    public function getSrid()
    {
        return $this->srid;
    }

    public function setSrid($srid)
    {
        $this->srid = $srid;
    }

}
