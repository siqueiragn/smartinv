
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
