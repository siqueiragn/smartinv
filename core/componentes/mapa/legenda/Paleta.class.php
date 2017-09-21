<?php
/*
 * Copyright Error: on line 4, column 29 in Templates/Licenses/license-apache20.txt
  The string doesn't match the expected date/time format. The string to parse was: "11/03/2016". The expected format was: "MMM d, yyyy". marcio.
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
 * Description of Paleta
 * As paletas podem ser geradas utilizando
 *  - http://colorbrewer2.org/
 *  - 
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class Paleta
{
    private $paleta = array(
        'BLUE' => array('b3e5fc', '81d4fa', '29b6f6', '039be5', '0288d1',  '0277b9', '01579b')
    );
    private $cor;
      
    public function __construct($cor = 'BLUE')
    {
        $this->cor = $cor;
    }
     
    public function getCor($i){
        return $this->paleta[$this->cor][$i];
                
    }
    
    
}
