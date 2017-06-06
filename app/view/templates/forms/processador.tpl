{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Processador</legend>
             <input type="hidden" id="idProcessador" name="idProcessador" value="{$processador->getIdProcessador()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$processador->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="frequencia">Frequencia</label>
              <div class="col-sm-8">
                 <input type="text" id="frequencia" name="frequencia" value="{$processador->getFrequencia()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="socket">Socket</label>
              <div class="col-sm-8">
                 <input type="text" id="socket" name="socket" value="{$processador->getSocket()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$processador->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$processador->getComputador()}
             </select>

              </div>
         </div>
</fieldset>

