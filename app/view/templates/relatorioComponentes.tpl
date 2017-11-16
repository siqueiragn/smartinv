<div class="col-md-12 wrapper">

<ul style="list-style: none">
<li> O total de Placas Mãe: {$cPlacaMae} </li>
<li> O total de Processadores: {$cProcessador}</li>
<li> O total de Memórias RAM: {$cMemoria}</li>
<li> O total de Disco Rígidos: {$cDiscoRigido}</li>
<li> O total de Placas de Vídeo: {$cPlacaVideo}</li>
<li> O total de Fontes de Alimentação: {$cFonte} </li>
<li> O total de Drivers: {$cDriver} </li>
<li> A soma total de componentes em estoque é: {$cDriver+$cPlacaMae+$cProcessador+$cMemoria+$cDiscoRigido+$cPlacaVideo+$cFonte} </li>


</div>




<div class="row">
<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Slot </th>
<th style="padding: 10px">Socket</th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=pM from=$placaMae}

<td style="padding: 10px"> {$pM->getID()} </td>
<td style="padding: 10px"> {$pM->getNome()} </td>
<td style="padding: 10px"> {$pM->getSlotMemoria()} </td>
<td style="padding: 10px"> {$pM->getSocket()} </td>
<td style="padding: 10px"> {if $pM->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>

<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Socket </th>
<th style="padding: 10px">Frequência</th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=proc from=$processador}

<td style="padding: 10px"> {$proc->getID()} </td>
<td style="padding: 10px"> {$proc->getNome()} </td>
<td style="padding: 10px"> {$proc->getSocket()} </td>
<td style="padding: 10px"> {$proc->getFrequencia()} </td>
<td style="padding: 10px"> {if $proc->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>
</div>



<div class="row" style="margin-top: 20px">




<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Frequencia </th>
<th style="padding: 10px">Capacidade</th>
<th style="padding: 10px">Tipo</th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=mem from=$memoria}

<td style="padding: 10px"> {$mem->getID()} </td>
<td style="padding: 10px"> {$mem->getNome()} </td>
<td style="padding: 10px"> {$mem->getFrequencia()} </td>
<td style="padding: 10px"> {$mem->getCapacidade()} </td>
<td style="padding: 10px"> {$mem->getTipo()} </td>
<td style="padding: 10px"> {if $mem->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>

<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Capacidade </th>
<th style="padding: 10px">Cache</th>
<th style="padding: 10px">RPM</th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=disco from=$discoRigido}

<td style="padding: 10px"> {$disco->getID()} </td>
<td style="padding: 10px"> {$disco->getNome()} </td>
<td style="padding: 10px"> {$disco->getCapacidade()} </td>
<td style="padding: 10px"> {$disco->getvCache()} </td>
<td style="padding: 10px"> {$disco->getRPM()} </td>
<td style="padding: 10px"> {if $disco->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>

</div>


<div class="row" style="margin-top: 20px">




<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Frequencia </th>
<th style="padding: 10px">Memória</th>
<th style="padding: 10px">Tipo</th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=pV from=$placaVideo}

<td style="padding: 10px"> {$pV->getID()} </td>
<td style="padding: 10px"> {$pV->getNome()} </td>
<td style="padding: 10px"> {$pV->getFrequencia()} </td>
<td style="padding: 10px"> {$pV->getMemoria()} </td>
<td style="padding: 10px"> {$pV->getTipo()} </td>
<td style="padding: 10px"> {if $pV->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>

<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Potência </th>
<th style="padding: 10px">Computador </th>

</tr>
{foreach item=ft from=$fonte}

<td style="padding: 10px"> {$ft->getID()} </td>
<td style="padding: 10px"> {$ft->getNome()} </td>
<td style="padding: 10px"> {$ft->getPotencia()} </td>


<td style="padding: 10px"> {if $ft->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>

</div>





<div class="row" style="margin-top: 20px">




<div class="col-md-6 wrapper">
<table border=2>

<tr>
<th style="padding: 10px">ID</th>
<th style="padding: 10px">Nome </th>
<th style="padding: 10px">Velocidade </th>
<th style="padding: 10px">Computador</th>
</tr>
{foreach item=drv from=$driver}

<td style="padding: 10px"> {$drv->getID()} </td>
<td style="padding: 10px"> {$drv->getNome()} </td>
<td style="padding: 10px"> {$drv->getVelocidade()} </td>
<td style="padding: 10px"> {if $drv->getComputador() != 0} Vinculado {else} Não possui computador {/if} </td>
</tr>
{/foreach}
	</table>
</div>
