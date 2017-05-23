<?php

/*
 * Copyright .
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Description of LegendaHeat
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class ItemLegendaHeatPattern extends ItemLegendaHeat implements \JsonSerializable
{


    private $pattern;
    

    public function __construct($minimo, $maximo, $pattern)
    {
        parent::__construct($minimo, $maximo, '#000000');
        $this->pattern = $pattern;
    }

    
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize() , get_object_vars($this));
    }

}
