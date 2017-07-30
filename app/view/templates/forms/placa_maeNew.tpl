{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Placa mae</legend>
             <input type="hidden" id="idPlacaMae" name="idPlacaMae" value="{$placaMae->getIdPlacaMae()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$placaMae->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="socket">Socket</label>
              <div class="col-sm-8">
                 <input type="text" id="socket" name="socket" value="{$placaMae->getSocket()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$placaMae->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$placaMae->getComputador()}
             </select>

              </div>
         </div>
</fieldset>

