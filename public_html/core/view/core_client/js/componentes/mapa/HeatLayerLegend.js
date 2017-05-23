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