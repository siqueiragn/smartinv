/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function camada(tipo) {
    /**
     * 1 = VectorLayer
     * 2 = MapServer
     *
     * @var Integer 
     */
    this.tipo = tipo;
    this.alteraCorBorda = function() {
        if (this.tipo == 1) {

        }
    };
    this.alteraCorPreenchimento = function() {
    };
    this.alteraTransparencia = function() {
    };
}


function itemSelect(value, label) {
    this.value = value;
    this.label = label;
    this.subArvore = new Array();
}
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

function estiloCluster(icone) {
    var colors = {
        low: "rgb(181, 226, 140)",
        middle: "rgb(241, 211, 87)",
        high: "rgb(253, 156, 115)"
    };

    var unique = new OpenLayers.Rule({
        filter: new OpenLayers.Filter.Comparison({
            type: OpenLayers.Filter.Comparison.EQUAL_TO,
            property: "count",
            value: 1
        }),
        symbolizer: {
            externalGraphic: icone[0],
            fillColor: colors.low,
            fillOpacity: 0.9,
            strokeColor: colors.low,
            strokeOpacity: 0.5,
            strokeWidth: 12,
            pointRadius: 10,
            label: "${count}",
            labelOutlineWidth: 1,
            fontColor: "#000000",
            fontSize: "9px",
            fontWeight: 'bold'
        }
    });
    var lowRule = new OpenLayers.Rule({
        filter: new OpenLayers.Filter.Comparison({
            type: OpenLayers.Filter.Comparison.BETWEEN,
            property: "count",
            lowerBoundary: 2,
            upperBoundary: 16
        }),
        symbolizer: {
            externalGraphic: icone[1],
            fillColor: colors.low,
            fillOpacity: 0.9,
            strokeColor: colors.low,
            strokeOpacity: 0.5,
            strokeWidth: 12,
            pointRadius: 10,
            label: "${count}",
            labelOutlineWidth: 1,
            fontColor: "#000000",
            fontSize: "9px",
            fontWeight: 'bold'

        }
    });
    var middleRule = new OpenLayers.Rule({
        filter: new OpenLayers.Filter.Comparison({
            type: OpenLayers.Filter.Comparison.BETWEEN,
            property: "count",
            lowerBoundary: 15,
            upperBoundary: 50
        }),
        symbolizer: {
            externalGraphic: icone[2],
            fillColor: colors.middle,
            fillOpacity: 0.9,
            strokeColor: colors.middle,
            strokeOpacity: 0.5,
            strokeWidth: 12,
            pointRadius: 15,
            label: "${count}",
            labelOutlineWidth: 1,
            fontColor: "#000000",
            fontWeight: 'bold',
            fontSize: "9px"
        }
    });
    var highRule = new OpenLayers.Rule({
        filter: new OpenLayers.Filter.Comparison({
            type: OpenLayers.Filter.Comparison.GREATER_THAN,
            property: "count",
            value: 50
        }),
        symbolizer: {
            externalGraphic: icone[3],
            fillColor: colors.high,
            fillOpacity: 0.9,
            strokeColor: colors.high,
            strokeOpacity: 0.5,
            strokeWidth: 12,
            pointRadius: 20,
            label: "${count}",
            labelOutlineWidth: 1,
            fontColor: "#000000",
            fontSize: "9px",
            fontWeight: 'bold'

        }
    });

    // Create a Style that uses the three previous rules
    var style = new OpenLayers.Style(null, {
        rules: [unique, lowRule, middleRule, highRule]
    });

    return style;
}

function ClusterBuilder(){
    this.geraLegenda = function(obj, html){
            html = html.substring(0, (html.length - 8));
            html += '<sub><a href="#" id="maisCluster' + id + '" class="maisCluster">[-] Agrupamento</a></sub></label>';
            html += ' <ul class="clusterOption" id="clusterOption' + id + '"> ';
            html += '   <li> <label class="makeCluster">';
            html += '     <input type="checkbox"  name="cluster' + id + '" ';
            html += '              id="makeCluster' + id + '" />Criar agrupamento</label><ul class="legendaCluster">';
            var tam = 20;
            for (var a in itemLegenda.geradorIcone) {
                html += '<li> <img src="' + itemLegenda.geradorIcone[a] + '" width="' + tam + '" height="' + tam + '"/>  </li>';
                tam += 3;
            }
            html += '</ul>  <div style="clear:both"></div>';
            html += ' </li> <li class="restricoesCluster" id="restricoesCluster' + id + '">';
            if (itemLegenda.ingles) {
                html += '   <label class="camposRestricao"> Dimension';
            } else {
                html += '   <label class="camposRestricao"> Dimensão';
            }
            html += '     <select name="dimension' + id + '" id="dimension' + id + '">';
            html += '               <option value="none">Nenhuma</option>';
            for (var a in dim) {
                html += '<option value="' + a + '">' + dim[a].label + '</option>';
            }

            html += '           </select> </label>';
            html += '  <label class="camposRestricao">Regra';
            html += '     <select name="restricao' + id + '" id="restricao' + id + '">';
            html += '             <option value="none">Nenhuma</option>';
            html += '     </select> </label>';
            html += ' <p style="margin-top: 12px; text-indent: 2px;">';
            html += '<a href="" title="Adicionar restrição" id="adicionarRestricao' + id + '" > E </a></p>';
            html += '<label class="somenteUmGrupo"> <input type="checkbox" id="somenteUmGrupo' + id + '" value="true"/> Apenas um grupo</label>';

            if (itemLegenda.ingles) {
                html += '<label class="campoRestricaoSlider" id="campoRestricaoSlider' + id + '">Size cluster:';
            } else {
                html += '<label class="campoRestricaoSlider" id="campoRestricaoSlider' + id + '">Tamanho agrupamento:';
            }

            html += '<input type="text" id="valorSliderCluster' + id + '" />';

            html += '<div id="sliderCluster' + id + '"></div></label>';
            if (experimento == 2) {
                html += '<div class="selecionaAno"> <input type="text" id="anoMinimo' + id + '" class="anoMinimo"/>';
                html += '<input type="text" id="anoMaximo' + id + '" class="anoMaximo"/>';
                html += '<div id="sliderYearRange' + id + '"></div></div>';
            }
            html += '<p class="duplicarCluster">';
            html += '        <a href="" id="duplicarCluster' + id + '" title="Duplicar plano de informação"> [+] Duplicar</a></p>';
            html += '</li></ul><div style="clear:both"></div>';
    }
    
    this.geraAcao = function(ctx){
           ctx.adicionaEventoClick(ctx.camadas[id]);
            var camadaCluster = new CamadaCluster(id, ctx);
            camadaCluster.features = ctx.camadas[id].features;
            camadaCluster.styles = ctx.camadas[id].styleMap;
            ctx.camadas[id] = camadaCluster;
            camadaCluster.itemLegenda = itemLegenda;
            itemLegenda.maisCluster = false;
            if (!itemLegenda.checked) {
                that.camadas[id].setVisibility(false);
            }
            $("#restricoesCluster" + id).hide();
            $("#valorSliderCluster" + id).val(35);
            $('#sliderCluster' + id).slider({
                value: 35,
                min: 0,
                max: 100,
                step: 5,
                slide: function (event, ui) {
                    $("#valorSliderCluster" + id).val(ui.value);
                }, stop: function (event, ui) {
                    camadaCluster.trocaTamanho(ui.value);
                }
            });
            if (experimento == 2) {
                $("#sliderYearRange" + id).slider({
                    range: true,
                    min: 1980,
                    max: 2014,
                    values: [1980, 2014],
                    slide: function (event, ui) {
                        $("#anoMinimo" + id).val(ui.values[ 0 ]);
                        $("#anoMaximo" + id).val(ui.values[ 1 ]);
                    }, stop: function (event, ui) {

                        var regra = {
                            dimensao: 'tempo',
                            regra: 'ano_numero',
                            valor: [ui.values[0], ui.values[1]]
                        };
                        camadaCluster.adicionaRegra(regra);

                        $.ajax({
                            url: itemLegenda.fonteDeDados,
                            type: "POST",
                            data: "restricao=" + $.toJSON(camadaCluster.enviaRegras()),
                            dataType: "json",
                            success: function (camadas) {
                                camadaCluster.adicionaCamadaComRegra(camadas);
                            }
                        });



                        camadaCluster.addTempo(ui.values);
                    }
                });
                $("#anoMinimo" + id).val($("#sliderYearRange" + id).slider("values", 0));
                $("#anoMaximo" + id).val($("#sliderYearRange" + id).slider("values", 1));
            }
            $('#maisCluster' + id).click(function () {
                if (itemLegenda.maisCluster) {
                    $('#clusterOption' + id).show('fast');
                    $('#maisCluster' + id).html('[-] Agrupamento');
                    itemLegenda.maisCluster = false;
                } else {
                    $('#clusterOption' + id).hide('fast');
                    $('#maisCluster' + id).html('[+] Agrupamento');
                    itemLegenda.maisCluster = true;
                }
                return false;
            });

            $('#makeCluster' + id).click(
                    function () {
                        var timeInicial = new Date().getTime();
                        camadaCluster.makeCluster(id);
                        var timeFinal = new Date().getTime();
                        var tempoTotal = new Date(timeFinal - timeInicial)
                        console.log("t1 = " + timeInicial + " t2 " + timeFinal + "Total de " + tempoTotal.getSeconds())

                    }
            );

            $('#dimension' + id).change(function () {
                if ($(this).val() !== 'none') {
                    var restrict = dim[$(this).val()].values;
                    $('#restricao' + id).html('<option value="none">Selecione</option>');
                    for (var a in restrict) {
                        $('#restricao' + id).append('<option value="' + a + '">'
                                + restrict[a] + '</option>');
                    }
                } else {

                    $('#restricao' + id).html('<option value="none">Nenhuma</option>');
                }
            });

            $('#restricao' + id).change(function () {
                if ($(this).val() == 'none') {
                    var regra = {
                        dimensao: $('#dimension' + id).val()
                    };

                    camadaCluster.removeRegra(regra);
                    $.ajax({
                        url: itemLegenda.fonteDeDados,
                        type: "POST",
                        data: "restricao=" + $.toJSON(camadaCluster.enviaRegras()),
                        dataType: "json",
                        success: function (camadas) {
                            camadaCluster.adicionaCamadaComRegra(camadas);
                        }
                    });
                } else if ($(this).val() !== 'passa') {
                    var regra = {
                        dimensao: $('#dimension' + id).val(),
                        regra: $(this).val()
                    };
                    camadaCluster.adicionaRegra(regra);
                    $.ajax({
                        url: itemLegenda.fonteDeDados,
                        type: "POST",
                        data: "restricao=" + $.toJSON(camadaCluster.enviaRegras()),
                        dataType: "json",
                        success: function (camadas) {
                            camadaCluster.adicionaCamadaComRegra(camadas);
                        }
                    });
                } else {
                    //#todo ver no caso de zoom
                    alert('Sem classificação significativa para esses dados! Necessário dados mais confiaveis ou escala diferente!');
                }
            });

            $('#duplicarCluster' + id).click(function () {
                camadaCluster.duplicaCamada(itemLegenda)
                return false;
            });

            $('#adicionarRestricao' + id).click(function () {
                faltaImplementar();
                return false;
            });

            $('#somenteUmGrupo' + id).click(function () {
                if ($('#somenteUmGrupo' + id).is(":checked")) {
                    camadaCluster.trocaTamanho(100000);
                    $('#campoRestricaoSlider' + id).hide('puff')
                } else {
                    var v = $("#valorSliderCluster" + id).val();
                    camadaCluster.trocaTamanho(v);
                    $('#campoRestricaoSlider' + id).show('puff')
                }
            });


            if (itemLegenda.estadoCluster == 2) {
                $('#maisCluster' + id).trigger('click');
            }
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function HeatLayerLegend(legenda) {
    var item, advancedData;
    var html = '<a href="#" id="btnInfo' + legenda.idCamada + '">[show]</a><div id="info' + legenda.idCamada + '">Legenda layer:';
    html += '<ul class="legendaInterna">';
    for (var i in legenda.info) {
        item = legenda.info[i];
        advancedData = '<span class="advancedData"></span>';
    //        html += '<li><span class="icone" ><canvas class="canvasLegenda" data-id-camada="'+legenda.idCamada +'" data-camada-pattern="' + item.pattern +'"></canvas></span>' + item.nome + btMaisInfo(legenda, i) + '</li>';
    // normal 
           html += '<li><span class="icone" style="background-color:' + item.cor + '"></span>' + item.nome + btMaisInfo(legenda, i) + '</li>';
    }
    html += '</ul></div>';
    return html;
}

function executeCanvas(){
    $('.canvasLegenda').each(function(e, el){
        var pattern = $(el).data('data-camada-pattern');
        console.log(pattern);
        makePattern('#66666', pattern, el);
    });
}

function HeatLayerActions(legenda) {
    $("#info" + legenda.idCamada).hide();
    $("#btnInfo" + legenda.idCamada).click(function () {
        $("#info" + legenda.idCamada).toggle();
    });

    $(".subItemData").click(function (i) {
        var cor = $(i.currentTarget).data('id');
        console.log(estatistica)
        for (var a in legenda3) {
            console.log(legenda3[a].nome + ' = ' + estatistica.esfOuUBS[legenda3[a].cor]);
        }

    });
}

function getCor(value, legenda) {
    for (var a in legenda) {
        if (parseFloat(legenda[a].minimo) <= value && parseFloat(legenda[a].maximo) >= value) {
            return legenda[a].cor;
        }
    }
    return makePattern('#666', 'linear');
}

function armazenaEstatistica(dataSet, dataItem) {
    if (!estatistica[dataSet]) {
        estatistica[dataSet] = new Object();
    }
    if (estatistica[dataSet][dataItem]) {
        estatistica[dataSet][dataItem]++;
    } else {
        estatistica[dataSet][dataItem] = 1;
    }
}

function btMaisInfo(legenda, i) {
    var html = '<a href="#id=" data-id="' + legenda.info[i].cor +
            '" data-layer-data="' + legenda.vetorDataName +
            '" class="subItemData" title="Mais informações">[+]</a>';

    return html;
}
//TODO tranformar em legenda
/**
 * 
 * @param {type} nome
 * @param {inteiro} id
 * @returns {ItemLegenda}
 */
function ItemLegenda(nome, id) {
    this.nome = nome;
    this.icone = '/media/mapas/linha.png';
    this.nomeIcone = 'suino.png';
    this.geradorIcone = false;
    this.cluster = false;
    this.subItem = false;
    this.style = false;
    this.idCamada = id;
    this.checked = true;
    this.dim = new Array();
    this.click = false;
    this.ingles = false;
    this.fonteDeDados = '';
    this.cor = '';   
    this.grupo = false;
    this.info = false;
    this.vetorDataName = ''; 
  
    this.setCor = function (cor){
        this.cor = 'background-color:' + cor + ';';
    };
  
   if (typeof ItemLegenda.i === 'undefined') {
        ItemLegenda.i = 0;
    }
    return ++ItemLegenda.i;
}
/* 
 * Copyright Error: on line 4, column 29 in Templates/Licenses/license-apache20.txt
 The string doesn't match the expected date/time format. The string to parse was: "21/03/2016". The expected format was: "MMM d, yyyy". marcio.
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
function eventosLegenda(){

    $( "#sortable" ).sortable({
      revert: true
    });
    $( "#draggable" ).draggable({
      connectToSortable: "#sortable",
      helper: "clone",
      revert: "invalid"
    });
    $( "ul, li" ).disableSelection();
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function makeAutoPattern(value, legenda) {
    for (var a in legenda) {
        if (parseFloat(legenda[a].minimo) <= value && parseFloat(legenda[a].maximo) >= value) {
            return makePattern(legenda[a].cor, legenda[a].pattern);
        }
    }
    return makePattern('#666666', 'solid');
}


/**
 * 
 * @param {type} color
 * @param {type} pattern
 * @returns {pattern}
 */
function makePattern(color, pattern) {
    
    if(!isNull(arguments[2])){
        var cnv = arguments[2];
    }else{
        var cnv = document.createElement('canvas');       
    }
     var ctx = cnv.getContext('2d');
    

    var patterns = new Object();

    patterns.linear = function () {
        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 1, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };
       
    patterns.linear2 = function () {
        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 2, 2);
        }

        return ctx.createPattern(cnv, 'repeat');
    };
    
    patterns.verticalLinear = function () {
        cnv.width = 6;
        cnv.height = 1;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(1, 0, 1, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };

    patterns.dashed = function () {

        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;


        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 4, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };

    patterns.solid = function () {
        cnv.height = 6;
        cnv.width = 6;
        ctx.fillStyle = color;

        ctx.fillRect(6, 6, 6, 6);

        return ctx.createPattern(cnv, 'repeat');
    };



    if (isNull(patterns[pattern])) {
        return patterns.solid();
    } else {
        console.log('oiiii')
        return patterns[pattern]();
    }


}



/**
 * Metodo que identifica o tamanho da janela e modifica o mapa para que se ajusta
 * na altura da janela
 * 
 * @returns {void}
 */
function tamanhoMapa() {
    var altura = $("body").height() - 51;//Menu padrão bootstrap
    $("#" + this.idMapa).css('height', altura);
    $("#principal").css('height', altura);
}

//Objeto Mapa
function Mapa(mapa) {
    this.legenda = new Array();

    this.caminho = new Caminho();

    //Vetor de camadas
    this.camadas = new Array();

    //Vetor de features para camadas de 
    this.features = new Array();

    //Vetor de styles para camadas de 
    this.styles = new Array();

    //contador de idCamada
    this.id = 0;

    this.popUp = false;

    //O Mapa
    this.idMapa = mapa;
    
    
    this.zoom = 12;
    this.x = -5804847.164511;
    this.y = -3541988.011926;

    //Projeções
    //this.deProj = new OpenLayers.Projection("EPSG:4326"); // transform from WGS 1984
    //this.paraProj = new OpenLayers.Projection("EPSG:3857"); // to Spherical Mercator Projection

    this.setMapa = function(mapa) {
        this.map = mapa;
    };
    
    

    this.baseUrl = '';

    this.googleMap = function(view, olMapDiv ){
        var gmap = new google.maps.Map(document.getElementById(this.idMapa +'_gmap'), {
            disableDefaultUI: true,
            keyboardShortcuts: false,
            draggable: false,
            disableDoubleClickZoom: true,
            scrollwheel: false,
            streetViewControl: false,
             mapTypeId: google.maps.MapTypeId.SATELLITE
        });
        
        view.on('change:center', function () {
            var center = ol.proj.transform(view.getCenter(), 'EPSG:3857', 'EPSG:4326');
            gmap.setCenter(new google.maps.LatLng(center[1], center[0]));
        });
        view.on('change:resolution', function () {
            gmap.setZoom(view.getZoom());
        });   
        
        olMapDiv.parentNode.removeChild(olMapDiv);
        gmap.controls[google.maps.ControlPosition.TOP_LEFT].push(olMapDiv);
    };

    this.iniciaMapa = function () {
        
        tamanhoMapa();

        var view = new ol.View({
            // make sure the view doesn't go beyond the 22 zoom levels of Google Maps
            maxZoom: 21,
            projection: ol.proj.get('EPSG:3857'),
        });
 
       var olMapDiv = document.getElementById(this.idMapa + '_ol');
        this.map = new ol.Map({
            interactions: ol.interaction.defaults({
                altShiftDragRotate: false,
                dragPan: false,
                rotate: false,
             
            }).extend([new ol.interaction.DragPan({kinetic: null})]),
            controls: ol.control.defaults({
                    attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                        collapsible: false
                    })
                }).extend([
                   new ol.control.FullScreen(),
                   new ol.control.ScaleLine()
                ]),
            target: olMapDiv,
            view: view
        });
        
        //this.googleMap(view, olMapDiv);
        $('#' +this.idMapa + '_gmap').hide();
              
        view.setCenter([ this.x, this.y]);
        view.setZoom(this.zoom);       
    };
    
    this.getDivMapa = function(){
        return '#' +this.idMapa + '_ol';
    };
    
    /**
     *  Método que seta a url Base para o mapa para fazer as requisições de camadas
     *  ao mesmo servidor de mapas.
     *  
     * @param {type} baseUrl
     * @returns {undefined}
     */
    this.setBaseUrl = function(baseUrl){
        this.baseUrl = baseUrl;
    }   

    this.adicionaCamada = function(camada) {
        this.map.addLayer(camada);
        this.id++;
        this.camadas[this.id] = camada;
        return this.id;
    }

    this.adicionaItemLegenda = function(itemLegenda) {
        this.legenda.push(itemLegenda);
        var that = this;
        var id = itemLegenda.idCamada;
        var dim = itemLegenda.dim;
        var icone = itemLegenda.icone;
        if (itemLegenda.cluster) {
            classe = 'legendaComCluster';
        } else {
            classe = 'legendaNormal';
        }
        var html = '<li id="ordem' + id + '" class="' + classe + '"><div> <span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <label>';
        html += ' <input type="checkbox" id="layer' + id + '" class="mapOverlays"';
        if (itemLegenda.checked) {
            html += ' checked="checked" ';
        } else {
            that.camadas[id].setVisible(false);
        }
        html += ' /> <span id="icone' + id + '" class="icone" ';
        html += 'style="background-image:url(' + icone + '); ' + itemLegenda.cor + '"> </span>';
        html += itemLegenda.nome + " </label>";

        if (itemLegenda.cluster) {
            html += ClusterFactory.geraLegenda(this, html);
        }
        
        if(itemLegenda.info){
            html += HeatLayerLegend(itemLegenda);
           
        }

        html += '</div></li>';

        $("#legendaMapa .raiz").prepend(html);
         executeCanvas();
        $('#layer' + id).click(
                function () {
                    if ($('#layer' + id).is(":checked")) {
                        that.camadas[id].setVisible(true);
                    } else {
                        that.camadas[id].setVisible(false);
                    }
                }
        );

        if (itemLegenda.icone === 'linha.png') {
            $('#icone' + id).css('backgroundColor', '#f00');
        }


        if (itemLegenda.cluster) {
            ClusterFactory().geraAcoes(this);//Somente executado depois de inserir o html na página
        }
        if(itemLegenda.info){
            HeatLayerActions(itemLegenda);
        }
    };

    /**
     * Função que realiza a troca de camada por uma com caracteristicas diferentes
     * 
     * @returns none
     */
    this.changeLayer = function(layer, id) {
    };

    this.geraCamadaPontoJson = function(url, icone) {
        var vector = new ol.Layer.Vector("Features", {
            protocol: new OpenLayers.Protocol.HTTP({
                url: url,
                format: new OpenLayers.Format.GeoJSON()
            }),
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: icone,
                graphicWidth: 25,
                graphicHeight: 25,
                fillOpacity: 1


            }),
            renderers: ['Canvas', 'SVG'],
            strategies: [new OpenLayers.Strategy.Fixed()]
        });

        return vector;
    };

    this.adicionaCamadaPontoJson = function(url, icone) {

        var vector = this.geraCamadaPontoJson(url, icone);

        return this.adicionaCamada(vector);
    }

    this.adicionaCamadaMapServer = function (camada, url) {
        var layer = new ol.layer.Image({
            showMenu: true,
            source: new ol.source.ImageWMS({
                url: 'http://localhost/cgi-bin/mapserv?',
                params: {
                    'LAYERS': camada,
                    'mode': 'map',
                    'map': url,
                    'TRANSPARENT': 'true',
                    'FORMAT': 'image/png',
                },
                projection: ol.proj.get('EPSG:3857'),
                serverType: 'mapserver'
            }), extent: [-5689990, -3580000, -5680000, -3490000]
        });
//  

        return this.adicionaCamada(layer);
    }

    this.adicionaCamadaKML = function(camada) {
        var url = this.caminho.KML + camada + '.kml';
        var vector = new ol.layer.Vector("KML", {
            projection: new ol.Projection("EPSG:4326"),
            strategies: [new ol.Strategy.Fixed()],
            protocol: new ol.Protocol.HTTP({
                url: url,
                format: new ol.Format.KML({
                    extractStyles: false,
                    extractAttributes: false
                })
            })
        });
        return this.adicionaCamada(vector);
    };

    this.adicionaCamadaPonto = function(nome) {
        var vector = new ol.layer.Vector(nome, {
            renderers: ['Canvas', 'SVG']
        });
        return this.adicionaCamada(vector);
    };

    this.adicionaPontoEmCamada = function(idCamada, px, py) {
        var pointGeometry = new ol.geometry.Point(px, py);
        var pointFeature = new ol.feature.Vector(pointGeometry);
        this.camadas[idCamada].push([pointFeature]);
    };
    
    /**
     * 
     * @param {type} url
     * @param {type} icone
     * @returns {undefined}
     */
    this.adicionaCamadaGeoJson = function(url, icone, customStyleFunction){
        var caminho = this.baseUrl + '/' + url;
        var layer = new ol.layer.Vector(
                {   title: 'added Layer',
                    source: new ol.source.Vector({
                        format: new ol.format.GeoJSON(),
                        url: caminho
                }), style: customStyleFunction 
        });
        return this.adicionaCamada(layer)
    }
}

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