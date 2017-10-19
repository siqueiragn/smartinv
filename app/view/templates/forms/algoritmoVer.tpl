{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Algoritmo</legend>
             <input type="hidden" id="idAlgoritmo" name="idAlgoritmo" value="{$algoritmo->getIdAlgoritmo()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="idPlacaMae">Id placa mae</label>
              <div class="col-sm-8">
                 <input type="text" id="idPlacaMae" name="idPlacaMae" value="{$algoritmo->getIdPlacaMae()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idProcessador">Id processador</label>
              <div class="col-sm-8">
                 <input type="text" id="idProcessador" name="idProcessador" value="{$algoritmo->getIdProcessador()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idFonte">Id fonte</label>
              <div class="col-sm-8">
                 <input type="text" id="idFonte" name="idFonte" value="{$algoritmo->getIdFonte()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idMemoria">Id memoria</label>
              <div class="col-sm-8">
                 <input type="text" id="idMemoria" name="idMemoria" value="{$algoritmo->getIdMemoria()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idDiscoRigido">Id disco rigido</label>
              <div class="col-sm-8">
                 <input type="text" id="idDiscoRigido" name="idDiscoRigido" value="{$algoritmo->getIdDiscoRigido()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idComputador">Id computador</label>
              <div class="col-sm-8">
                 <input type="text" id="idComputador" name="idComputador" value="{$algoritmo->getIdComputador()}" class="validaInteiro form-control"  />
              </div>
         </div>
</fieldset>

