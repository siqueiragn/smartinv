{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Algoritmo</legend>
             <input type="hidden" id="idAlgoritmo" name="idAlgoritmo" value="{$algoritmo->getIdAlgoritmo()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="idPlacaMae">Placa Mãe</label>
              <div class="col-sm-8">
                 <input type="text" id="idPlacaMae" name="idPlacaMae" value="{$algoritmo->getIdPlacaMae()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idProcessador">Processador</label>
              <div class="col-sm-8">
                 <input type="text" id="idProcessador" name="idProcessador" value="{$algoritmo->getIdProcessador()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idFonte">Fonte</label>
              <div class="col-sm-8">
                 <input type="text" id="idFonte" name="idFonte" value="{$algoritmo->getIdFonte()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idMemoria">Memória RAM</label>
              <div class="col-sm-8">
                 <input type="text" id="idMemoria" name="idMemoria" value="{$algoritmo->getIdMemoria()}" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="idDiscoRigido">Disco Rígido</label>
              <div class="col-sm-8">
                 <input type="text" id="idDiscoRigido" name="idDiscoRigido" value="{$algoritmo->getIdDiscoRigido()}" class="validaInteiro form-control"  />
              </div>
         </div>
 
</fieldset>
	<fieldset id="formFinal">
                    <div class="form-group">

                    <div class="col-sm-offset-2 col-sm-1">
                        <a class="btn btn-default btn-danger" href="../deletarFim/{$id}">Excluir</a>
                        
                    </div>

                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-default btn-success">Enviar</button>
                    </div>
                </div>
 	</fieldset>
	
    </fieldset>
</form>

