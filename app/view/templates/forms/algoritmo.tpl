<fieldset class="formPadrao">
<ol>
{foreach item=computador from=$lista}
<li> Computador
	<ul>
<li> Placa Mãe: {$computador['id_placa_mae']}</li>
<li> Processador: {$computador['id_processador']}</li>
<li> Memória: {$computador['id_memoria']} </li>
<li> Disco Rigido: {$computador['id_disco_rigido']} </li>
<li> Fonte: {$computador['id_fonte']}</li>
</ul>
</li>
<hr >
{/foreach}
</ol>


<form method="POST" action="algoritmo/editar/{$url['min']}">
    
<button style="margin-top: 3px" type="submit">
           Prosseguir
           </button>
    
    
</form>
</fieldset>
