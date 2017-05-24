/**
 * verifica se a variável é null 
 * @param {misc} variavel
 * @returns {Boolean}
 */
function isNull(variavel) {
    if (typeof (variavel) !== 'undefined' && variavel != null) {
        return false;
    } else {
        return true;
    }
}

/**
 * Método que verifica se uma variavel é um número simplicando a sintaxe do teste
 * 
 * @param {misc} val
 * @returns {Boolean}
 */
function isNumber(val){
    //alert(isNaN(val))
  return typeof val === "number" && !isNaN(val);
}