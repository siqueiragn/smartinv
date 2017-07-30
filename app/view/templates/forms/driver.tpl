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
              <label class="control-label col-sm-2" for="velocidade">Velocidade</label>
              <div class="col-sm-8">
                 <input type="text" id="velocidade" name="velocidade" value="{$driver->getVelocidade()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$driver->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="barramento">Barramento</label>
              <div class="col-sm-8">
                 <select id="barramento" name="barramento" class="form-control">
    		{html_options options=$listaBarramento selected=$driver->getBarramento()}
             </select>

              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$driver->getComputador()}
             </select>

              </div>
         </div>
</fieldset>

