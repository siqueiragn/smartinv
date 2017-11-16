<ol>
{foreach item=computador key=key from=$lista}
<li> Computador {$key}
	<ul>
<li> Placa Mãe: {$computador['placa_mae']}</li>
<li> Processador: {$computador['processador']}</li>
<li> Memória: {$computador['memoria']} </li>
<li> Disco Rigido: {$computador['disco_rigido']} </li>
<li> Fonte: {$computador['fonte']}</li>
<li> Drivers: {$computador['driver']}</li>
</ul>
</li>
<hr >
{/foreach}
</ol>