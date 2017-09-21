/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var gerarBanco = false;


$(document).ready(function(){
    $("#campos").hide();
    $("#conf").hide();
    $("#gerarBanco").click(function(){            
        $('#geracaoBanco').toggle(this.checked);
        if(gerarBanco){
            $("#geracaoDTO legend").html("Apenas DTOS das tabelas");
            $("#nomeDTO").html("Nome das tabelas (separadas por virgula)");
            $("#campos").hide("slow");
        }else{
            $("#geracaoDTO legend").html("Apenas DTOS");
            $("#nomeDTO").html("Nome do DTO");
            $("#campos").show("slow");
        }
        gerarBanco = gerarBanco ? false : true;
    });
    
    $("#openConf").click(function(){
        $('#conf').toggle();
    });
    
});