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

function PopUp(id) {
    this.id = id;
    this.elemento = null;
    this.mapa = null;
    that = this;

    this.make = function () {
        if (isNull(this.mapa)) {
            console.log('[anta] - definir o mapa antes');
        }
        $(this.mapa.getDivMapa()).append(generatePopUpHtml(this.id));
        /**
         * Elements that make up the popup.
         */
        this.container = document.getElementById(this.id);
        this.content = document.getElementById(this.id + '-content');
        this.closer = document.getElementById(this.id + '-closer');

        /**
         * Create an overlay to anchor the popup to the map.
         */
        this.overlay = new ol.Overlay({
            element: this.container
        });



        /**
         * Add a click handler to hide the popup.
         * @return {boolean} Don't follow the href.
         */
        this.closer.onclick = function () {
            that.overlay.setPosition(undefined);
             that.closer.blur();
            return false;
        };

        this.mapa.map.addOverlay(this.overlay)

    };



    this.setConteudo = function (conteudo) {
        $("#" + id + "-content").html(conteudo);
    };


    this.addEvento = function (elemento) {
        
        map = this.mapa.map;
        /**
         * Add a click handler to the map to render the popup.
         */
        this.mapa.map.on('click', function (evt) {
            var coordinate = evt.coordinate;
            that.displayFeatureInfo(evt.pixel, coordinate, elemento);
            that.overlay.setPosition(coordinate);
        });

    };

    /**
     * 
     * @returns {String}
     */
    function generatePopUpHtml(id) {
        var html =
                '    <div id="' + id + '" class="ol-popup">' +
                '        <a href="#" id="' + id + '-closer" class="ol-popup-closer"></a>' +
                '        <div id="' + id + '-content"></div>' +
                '    </div>';
        return html;
    }




    this.setMap = function (map) {
        this.mapa = map;
    };


    this.displayFeatureInfo = function (pixel, coordinate, getInformation) {
        var features = [];
        map.forEachFeatureAtPixel(pixel, function (feature, layer) {
            features.push(feature);
        });
        if (features.length > 0) {//Verificar se é para mostrar ou não ????
            var info = [];
            for (var i = 0; i < features.length; ++i) {
                
                info.push(getInformation(features[i]));
            }
            that.setConteudo( info.join('<hr> ') || '(unknown)');
        } else {
            that.setConteudo( 'no Info');
        }
    };






}