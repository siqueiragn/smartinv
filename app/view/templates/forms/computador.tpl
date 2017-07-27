{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Computador</legend>
             <input type="hidden" id="idComputador" name="idComputador" value="{$computador->getIdComputador()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$computador->getNome()}" class=" form-control"  />
              </div>
         </div>
         
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$computador->getDescricao()}</textarea>
             
              </div>   
         </div>
         
         <div class="form-group">
				<label class="control-label col-sm-2" for="descricao">Componentes</label>
         
        <div class="col-sm-8">
         <textarea id="descricao" name="DESC" class=" form-control" > {$placaMae->getNome()}</textarea>
        
         
         </div>
         </div>
</fieldset>

