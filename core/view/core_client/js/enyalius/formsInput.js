/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  function formsInput(){    ignoreKeys = [0, 9, 16, 17, 18, 36, 37, 38, 39, 40, 91];
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phoneDDD').mask('(00)0000-0000');
    $('.percent').mask('##0,00%', {reverse: true});
    $('.validaFloat').keypress(function (event) {
        if ((   event.which != 44 || //virgula             
                $(this).val().indexOf(',') != -1) 
                && (event.which < 48 || event.which > 57)
                &&   ignoreKeys.indexOf(event.which) === -1//Tabs setas e bakspace
            ) {
            
            event.preventDefault();            
        }
    });
    
    $('.validaInteiro').keypress(function (event) {
        if (  (event.which < 48 || event.which > 57)
                &&   ignoreKeys.indexOf(event.which) === -1//Tabs setas e bakspace
            ) {            
            event.preventDefault();            
        }
    });

}
$(document).ready(function () {
    formsInput();
  
});