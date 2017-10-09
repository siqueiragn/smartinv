{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
 <form class="form-horizontal" action="/barramentoPlacamae/criarNovoFim" method="POST">
         <input type="hidden" id="idPlacaMae" name="idPlacaMae" value="{$placaMae->getIdPlacaMae()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="newInterface">Interfaces</label>
              <div class="col-sm-8">
                 <select id="interface" name="idBarramento" class="form-control">
    		{html_options options=$lista}
             </select>
           
             </div>
               <button style="margin-top: 3px" type="submit">
           <span class="glyphicon glyphicon-plus"></span>
           </button>
              </div>
              
              
              
              
              <div class="form-group">
              <label class="control-label col-sm-2" for="interfaces">Lista de Interfaces</label>
              <div class="col-sm-8">
              {foreach key=key item=item from=$listaInt}
              <p> {$item} <a style="color: black" href="/BarramentoPlacamae/deletarFim/?idPMB={$key}&idMOBO={$placaMae->getIdPlacaMae()}"><span class="glyphicon glyphicon-remove" </span></a> </p>
              {/foreach}
              </div>
              </div></form>

</fieldset>

