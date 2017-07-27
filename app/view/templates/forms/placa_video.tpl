{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Placa video</legend>
             <input type="hidden" id="idPlacaVideo" name="idPlacaVideo" value="{$placaVideo->getIdPlacaVideo()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="{$placaVideo->getNome()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="frequencia">Frequencia</label>
              <div class="col-sm-8">
                 <input type="text" id="frequencia" name="frequencia" value="{$placaVideo->getFrequencia()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="memoria">Memoria</label>
              <div class="col-sm-8">
                 <input type="text" id="memoria" name="memoria" value="{$placaVideo->getMemoria()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="barramento">Barramento</label>
              <div class="col-sm-8">
                 <input type="text" id="barramento" name="barramento" value="{$placaVideo->getBarramento()}" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" >{$placaVideo->getDescricao()}</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		{html_options options=$listaComputador selected=$placaVideo->getComputador()}
             </select>

              </div>
         </div>
</fieldset>

