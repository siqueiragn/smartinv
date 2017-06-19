{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Memoria</legend>
             <input type="hidden" id="idMemoria" name="idMemoria" value="{$memoria->getIdMemoria()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$memoria->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="frequencia">Frequencia</label>
              <div class="col-sm-8">
                 <input type="text" id="frequencia" name="frequencia" value="{$memoria->getFrequencia()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo</label>
              <div class="col-sm-8">
                 <input type="text" id="tipo" name="tipo" value="{$memoria->getTipo()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$memoria->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$memoria->getComputador()}
             </select>

              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="capacidade">Capacidade</label>
              <div class="col-sm-8">
                 <input type="text" id="capacidade" name="capacidade" value="{$memoria->getCapacidade()}" class="validaInteiro form-control"  />
              </div>
         </div>
</fieldset>

