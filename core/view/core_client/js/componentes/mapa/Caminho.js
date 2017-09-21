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
 * 
 * @returns {Caminho}
 */ 
function Caminho() {
    //Atualiza a variavel caminho das imagens
    this.imagens = "imagens/";
    // Caminho do local onde estão os arquivos kml
    this.KML = '/dados_geograficos/';
    //caminho servidor
    this.base = '';
    //executor
    this.executor = false;

    this.getExecutor = function() {
        return this.base + this.executor;
    };

    this.getImagem = function() {
        return this.base + this.imagens;
    };
}
