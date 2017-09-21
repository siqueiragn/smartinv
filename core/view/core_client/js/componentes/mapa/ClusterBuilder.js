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