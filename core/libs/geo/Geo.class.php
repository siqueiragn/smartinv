<?php

namespace core\libs\geo;
/**
 * Description of Geo
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package core.libs.geo
 */
class Geo
{
    public function __construct()
    {
        self::load();
    }
    public static function load(){
        $loader = $GLOBALS['loader'];
        $loader->addClass('GeoType', CORE . 'libs/geo/GeoType');
        $loader->addClass('Point', CORE . 'libs/geo/Point');
        $loader->addClass('MultiPolygon', CORE . 'libs/geo/MultiPolygon');
}
}
