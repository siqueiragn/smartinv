{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Barramento placamae</legend>
             <input type="hidden" id="idBarramentoPlacamae" name="idBarramentoPlacamae" value="{$barramentoPlacamae->getIdBarramentoPlacamae()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="idBarramento">Id barramento</label>
              <div class="col-sm-8">
                 <select id="idBarramento" name="idBarramento" class="form-control">
    		{html_options options=$listaBarramento selected=$barramentoPlacamae->getIdBarramento()}
             </select>

              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idPlacaMae">Id placa mae</label>
              <div class="col-sm-8">
                 <select id="idPlacaMae" name="idPlacaMae" class="form-control">
    		{html_options options=$listaPlacaMae selected=$barramentoPlacamae->getIdPlacaMae()}
             </select>

              </div>
         </div>
</fieldset>

