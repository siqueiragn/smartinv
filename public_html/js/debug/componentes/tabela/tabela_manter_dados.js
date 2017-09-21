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
$.jgrid.defaults.width = 780;

function editarDado() {
    var id = $("#tabelaDadosManterDados").jqGrid('getGridParam', 'selrow');
    //alert(gr);
    if (id != null) {
        //$("#tabelaDados_manterDados").jqGrid('delGridRow',gr,{reloadAfterSubmit:false}); 
        location.href = tabelaManterDados.acaoEditarDado + '/' + id;
    } else {
        alert("Selecione um dado!");
    }

}

function adicionarDado() {
    location.href = tabelaManterDados.acaoAdicionarDado;
}


function deletarDado() {
    var id = $("#tabelaDadosManterDados").jqGrid('getGridParam', 'selrow');
    if (id) {
        if (window.confirm("Tem certeza que deseja apagar este dado? \n Essa ação é irreversível.")) {
            location.href = tabelaManterDados.acaoDeletarDado + '/' + id;
        }
    } else {
        alert("Por favor selecione um dado!");
    }
}

$(document).ready(function()
{
    
    var alturaAjuste = isNull(tabelaManterDados.altura)?0: tabelaManterDados.altura;
    
    largura = parseInt($('#conteudo').css('widt;h'));
    var tabelaPaginacao = "#tabelaPaginacaoManterDados";
    calculaLarguras(tabelaManterDados);
    objeto = {
        url: tabelaManterDados.dados,
        datatype: 'json',
        mtype: 'POST',
        styleUI : 'Bootstrap',
        colModel: tabelaManterDados.colunas,
        colNames: tabelaManterDados.labelsColunas,
        usepager: true,
        caption: tabelaManterDados.titulo,
        useRp: true,
        multiselect: !tabelaManterDados.selecaoSimples,
        pager: tabelaPaginacao,
        rowNum: 40,
        rowList: [40, 80, 120],
        editUrl: tabelaManterDados.dados,
        width: largura,
        height: alturaPagina() - alturaAjuste - 200,
        ondblClickRow: function(rowId) {
            editarDado();
        }
    };
    $("#tabelaDadosManterDados").jqGrid(objeto);
    $("#tabelaDadosManterDados").jqGrid('gridResize', {
        minWidth: 500,
        maxWidth: largura,
        minHeight: 80,
        maxHeight: 1200
    });


    $('#tabelaDadosManterDados').navGrid(tabelaPaginacao, {
        search: true,
        edit: false,
        add: false,
        del: false
    },
    {}, {}, {},
            {
                closeOnEscape: true,
                multipleSearch: true,
                closeAfterSearch: true
            }
    );

    $('#tabelaDadosManterDados').jqGrid('filterToolbar', {stringResult: true, searchOnEnter: false});

    $('#tabelaDadosManterDados').navSeparatorAdd(tabelaPaginacao,
            {
                sepclass: 'ui-separator',
                sepcontent: ''
            });

    //Botão deletar dados  
    if (tabelaManterDados.botaoDeletar) {
        $('#tabelaDadosManterDados').jqGrid('navButtonAdd',
                tabelaPaginacao, {
            caption: "",
            buttonicon: "glyphicon-trash",
            onClickButton: deletarDado,
            position: "last",
            title: "Deletar dado",
            cursor: "hand"
        });
    }

    //Botão editar dados                        
    if (tabelaManterDados.botaoEditar) {
        $('#tabelaDadosManterDados').jqGrid('navButtonAdd',
                tabelaPaginacao, {
            caption: "",
            buttonicon: "glyphicon-pencil",
            onClickButton: editarDado,
            position: "last",
            title: "Editar dado",
            cursor: "hand"
        });

    }

    //Botão de adicionar Dados   
    if (tabelaManterDados.botaoAdicionar) {
        $('#tabelaDadosManterDados').jqGrid('navButtonAdd',
                tabelaPaginacao, {
            caption: "",
            buttonicon: "glyphicon-plus",
            onClickButton: adicionarDado,
            position: "last",
            title: "Adicionar dado",
            cursor: "hand"
        });
    }

    $('#tabelaDadosManterDados').navSeparatorAdd(tabelaPaginacao,
            {
                sepclass: 'ui-separator',
                sepcontent: ''
            });



});