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