{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Disco rigido</legend>
             <input type="hidden" id="idDiscoRigido" name="idDiscoRigido" value="{$discoRigido->getIdDiscoRigido()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$discoRigido->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="vCache">V cache</label>
              <div class="col-sm-8">
                 <input type="text" id="vCache" name="vCache" value="{$discoRigido->getVCache()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="rpm">Rpm</label>
              <div class="col-sm-8">
                 <input type="text" id="rpm" name="rpm" value="{$discoRigido->getRpm()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$discoRigido->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$discoRigido->getComputador()}
             </select>

              </div>
         </div>
</fieldset>

