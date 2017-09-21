/* 
 * Copyright Error: on line 4, column 29 in Templates/Licenses/license-apache20.txt
 The string doesn't match the expected date/time format. The string to parse was: "13/03/2016". The expected format was: "MMM d, yyyy". marcio.
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
 

function calculaLarguras(tab) {
    var _tabela;
    if(typeof tabela == 'undefined' ){
        _tabela = tab;
    }else{
        _tabela = tabela[tab];
    }
    var colModel = _tabela.colunas;
    var larguraDisponivel = getLargura();
    var cols = new Array();
    var i = 0;
    for (var a in colModel) {
        if (colModel[a].width == 40) { //padrão para números
            larguraDisponivel -= 40;
        } else {
            cols[i++] = colModel[a];
        }
    }
    if(cols.length == 0){
        return true;
    }
    var larguraFinal = parseInt(larguraDisponivel / cols.length)-10;
    for (var a in cols) {
        cols[a].width = larguraFinal;
    }
}