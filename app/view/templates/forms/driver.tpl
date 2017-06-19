{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Driver</legend>
             <input type="hidden" id="idDriver" name="idDriver" value="{$driver->getIdDriver()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$driver->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$driver->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <input type="text" id="computador" name="computador" value="{$driver->getComputador()}" class="validaInteiro form-control" required  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idBarramento">Id barramento</label>
              <div class="col-sm-8">
                 <select id="idBarramento" name="idBarramento" class="form-control">
    		{html_options options=$listaBarramento selected=$driver->getIdBarramento()}
             </select>

              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idComputador">Id computador</label>
              <div class="col-sm-8">
                 <select id="idComputador" name="idComputador" class="form-control">
    		{html_options options=$listaComputador selected=$driver->getIdComputador()}
             </select>

              </div>
         </div>
</fieldset>

