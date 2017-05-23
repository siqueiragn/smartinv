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