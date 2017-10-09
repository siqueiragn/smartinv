<fieldset class="formPadrao">
<ol>
{foreach name=outer item=computador from=$lista}
<li> Computador
	<ul>
<li> Placa Mãe: {$computador['placa_mae']}</li>
<li> Processador: {$computador['processador']}</li>
<li> Memória: {$computador['memoria']} </li>
<li> Disco Rigido: {$computador['disco_rigido']} </li>
</ul>
</li>
<hr >
{/foreach}
</ol>

<h1> Gerado. </h1>
</fieldset>
