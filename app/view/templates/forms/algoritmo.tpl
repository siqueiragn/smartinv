<fieldset class="formPadrao">




{foreach name=outer item=computador from=$lista}
    

<h1> Placa Mãe: {$computador['placa_mae']}</h1>
<h1> Processador: {$computador['processador']}</h1>
<h1> Memória: {$computador['memoria']} </h1>
<hr >
{/foreach}
 



</fieldset>
