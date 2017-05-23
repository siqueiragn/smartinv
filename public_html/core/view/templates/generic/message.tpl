{if $MSG->isValida()} 
    <div id="mensagem" class="alert {$MSG->getTipoMensagem()} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {$MSG->getContent()}
    </div>
{/if}