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
function getIndiceTabela(a) {
    btId = a.currentTarget.id;
    bt = btId.split('_');
    return bt[1];
}

function getIdTabela(tab) {
    return "#tabelaDados" + tabela[tab].idTabela;
}

function dadosSelecionadosUrl(grid) {
    selecionados = $('.trSelected', grid);
    url = "";
    $.each(selecionados, function(i) {
        url += "&dado[" + i + "]=" + selecionados[i].id.replace('row', '');
    });

    return url;
}

function gerarGrafico(a) {
    url = '';
    i = getIndiceTabela(a);
    if (tabela[i].gerarGraficoSemConfirmacao == true) {
        dadosSelecionados = '';
    } else {
        id = $(getIdTabela(i)).jqGrid('getGridParam', 'selarrrow');
        var cont = 0;
        $.each(id, function(a) {
            url += "&dado[" + cont + "]=" + id[cont];
            cont++;
        });
        if (url == '') {
            alert("Você deve escolher pelo menos uma linha na tabela!");
            return false;
        }
    }

    if (tabela[i].graficoDinamico) {
        dadosSelecionados = dadosSelecionadosUrl(a);
        if (dadosSelecionados == 0) {
            alert("Você deve escolher pelo menos uma linha na tabela!");
            return false;
        }
    } else {
        dadosSelecionados = '';
    }
//    alert(tabela[i].acaoGerarGrafico + url);
    requisicao = $.ajax(
            {
                url: tabela[i].acaoGerarGrafico + url,
                type: 'get',
                dataType: "html"
            }
    );

    requisicao.done(function(data) {
        $('#graficoGerado').html(data);
    });
    requisicao.fail(function(jqXHR, textStatus) {
        $('#graficoGerado').html('<p class="erro">Problemas ao carregar o site. Tente novamente mais tarde!</p>');
    });
    $("#graficoGerado").dialog('open');
    return true;


}

function exportarPDF(a) {
    i = getIndiceTabela(a);
    var acao = tabela[i].acaoExportarPDF;
    var titulo = tabela[i].titulo;
    if(acao == 'padrao'){
        d = ($(getIdTabela(i)).jqGrid('jqGridExport', {exptype:'jsonstring'}));
        C =  $.parseJSON(d);

        location.href = 'exportarPDF?url='+encodeURIComponent(C.grid.url)+'&postData='+encodeURIComponent(JSON.stringify(C.grid.postData))+'&colModel='+encodeURIComponent(JSON.stringify(C.grid.colModel))+'&titulo='+titulo;
        return false;
    }else{
        location.href = acao;
    }
}

function gerarCSV(a) {
    i = getIndiceTabela(a);
    var acao = tabela[i].acaoGerarCSV;
    var titulo = tabela[i].titulo;
    if(acao == 'padrao'){
        d = ($(getIdTabela(i)).jqGrid('jqGridExport', {exptype:'jsonstring'}));
        C =  $.parseJSON(d);
        
        location.href = 'exportarCSV?url='+encodeURIComponent(C.grid.url)+'&postData='+encodeURIComponent(JSON.stringify(C.grid.postData))+'&colModel='+encodeURIComponent(JSON.stringify(C.grid.colModel))+'&titulo='+titulo;
        return false;
    }else{
        $(getIdTabela(i)).jqGrid('excelExport', {
            tag: 'csv', url: tabela[i].acaoGerarCSV
        });
    }
    //location.href = tabela[i].acaoGerarCSV;
}

function imprimir(a) {
    i = getIndiceTabela(a);
    window.open(tabela[i].acaoImprimir, 'impressao', 'width=800,height=500,scroll=yes');
}

function editar(a) {
    i = getIndiceTabela(a);
    var id = $(getIdTabela(i)).jqGrid('getGridParam', 'selrow');
    if (id) {
        location.href = tabela[i].acaoEditar + '?id=' + id;
    } else {
        alert("Por favor selecione um dado!");
    }
}

function deletar(a) {
    i = getIndiceTabela(a);
    var id = $(getIdTabela(i)).jqGrid('getGridParam', 'selrow');
    if (id) {
        if (window.confirm("Tem certeza que deseja apagar o arquivo? \n Essa ação é irreversível.")) {
            location.href = tabela[i].acaoDeletar + '?id=' + id;
        } else {
            return false;
        }
    } else {
        alert("Por favor selecione um dado!");
    }
}


function capturaAltura(tab){
   if(tabela.length == 1){       
        return alturaPagina();
    }else{
        tabela[tab].altura;
    }
}
  

$(document).ready(function()
{

    largura = parseInt($('body').css('width'))-5;

    for (tab in tabela) {
        tabelaPaginacao = "#tabelaPaginacao" + tabela[tab].idTabela;
        idTabela = getIdTabela(tab);
        calculaLarguras(tab)
        objeto = {
            url: tabela[tab].dados,
            datatype: 'json',
            styleUI : 'Bootstrap',
            mtype: 'POST',
            colNames: tabela[tab].labelsColunas,
            colModel: tabela[tab].colunas,
            multiselect: tabela[tab].selecaoSimples,
            usepager: true,
            sortable: tabela[tab].ordenavel,
            useRp: true,
            caption: tabela[tab].titulo,
            pager: tabelaPaginacao,
            rowNum: 300,
            //autowidth: true,
            width: largura,
            height: capturaAltura(tab),
            rowList: [80, 160, 200],
            viewrecords: true,
            showTableToggleBtn: true
        };
        
        $('.ui-jqgrid .ui-jqgrid-bdiv').css('overflow', 'auto');


        $(idTabela).jqGrid(objeto);

        $(idTabela).jqGrid('gridResize', {
            minWidth: 500,
            maxWidth: largura,
            minHeight: 200
            //maxHeight: 800
        });

        $(idTabela).jqGrid('setFrozenColumns');

        navegacao = $('#tabelaDados' + tabela[tab].idTabela).navGrid(
                tabelaPaginacao,
                {
                    search: true,
                    edit: false,
                    add: false,
                    del: false,
                    refresh: false
                },
        {caption: "Buscar"}, {}, {},
                {
                    closeOnEscape: true,
                    multipleSearch: true,
                    closeAfterSearch: true
                }
        );

        $('#tabelaDados' + tabela[tab].idTabela).navSeparatorAdd(tabelaPaginacao,
                {
                    sepclass: 'ui-separator',
                    sepcontent: ''
                });
        if (tabela[tab].filtrar) {
            $('#tabelaDados' + tabela[tab].idTabela).jqGrid('filterToolbar', {stringResult: true, searchOnEnter: false});
        }

        //Botão editar dados  
        if (tabela[tab].botaoEditar) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "Editar",
                buttonicon: "ui-icon-pencil",
                onClickButton: editar,
                position: 'last',
                title: "Editar informação",
                cursor: "hand",
                id: "btEditar_" + tab
            });
        }

        if (tabela[tab].botaoDeletar) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "Deletar",
                buttonicon: "ui-icon-trash",
                onClickButton: deletar,
                position: 'last',
                title: "Deletar informação",
                cursor: "hand",
                id: "btDeletar_" + tab
            });
        }
        if (tabela[tab].botaoImprimir) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "Imprimir",
                buttonicon: "ui-icon-print",
                onClickButton: imprimir,
                position: "last",
                title: "Imprimir",
                cursor: "hand",
                id: "btPrint_" + tab
            });
        }

        if (tabela[tab].botaoGerarGrafico) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "Gráfico",
                buttonicon: "gerarGraficoIco",
                onClickButton: gerarGrafico,
                title: "Gerar gráfico",
                position: 'last',
                cursor: "hand",
                id: "btGrafico_" + tab
            });

        }
        $('#tabelaDados' + tabela[tab].idTabela).navSeparatorAdd("#tabelaPaginacao" + tabela[tab].idTabela,
                {
                    sepclass: 'ui-separator',
                    sepcontent: ''
                });
        if (tabela[tab].botaoGerarCSV) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "CSV",
                buttonicon: "gerarCSVIco",
                onClickButton: gerarCSV,
                position: "last",
                title: "Gerar CSV",
                cursor: "hand",
                id: "btGerarCsv_" + tab
            });
        }

        if (tabela[tab].botaoExportarPDF) {
            navegacao.navButtonAdd(
                    tabelaPaginacao, {
                caption: "PDF",
                buttonicon: "exportarPDFIco",
                onClickButton: exportarPDF,
                position: "last",
                title: "Exportar PDF",
                cursor: "hand",
                id: "btExportar_" + tab
            });
        }
    }

    $("#graficoGerado").dialog({
        autoOpen: false,
        width: 600,
        height: 510,
        modal: true
    });
  
});

