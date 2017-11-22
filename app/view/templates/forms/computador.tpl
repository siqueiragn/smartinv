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
        <p style="display: {$exibirPM}"> Placa Mãe: {$placaMae->getID()} - {$placaMae->getNome()} - <strong>Socket:</strong> {$placaMae->getSocket()}</p>        
        <p style="display: {$exibirP}"> Processador: {$processador->getID()} - {$processador->getNome()} - <strong>Socket:</strong> {$processador->getSocket()}</p>
        {foreach item=memoria from=$listaMemoria}
        <p style="display: {$exibirM}"> Memória: {$memoria->getID()} - {$memoria->getNome()} - <strong>Tipo: </strong> {$memoria->getTipo()} - <strong>Capacidade:</strong> {$memoria->getCapacidade()} - <strong>Frequência:</strong> {$memoria->getFrequencia()}</p>
        {/foreach}
        {foreach item=discoRigido from=$listaDisco}
        <p style="display: {$exibirDR}"> Disco Rígido: {$discoRigido->getID()} - {$discoRigido->getNome()} - <strong>Capacidade:</strong> {$discoRigido->getCapacidade()} - <strong>RPM: </strong> {$discoRigido->getRPM()}</p>
        {/foreach}
        <p style="display: {$exibirF}"> Fonte de Alimentação: {$fonte->getID()} - {$fonte->getNome()} - <strong>Potência:</strong> {$fonte->getPotencia()} </p>
        <p style="display: {$exibirPV}"> Placa de Video: {$placaVideo->getID()} - {$placaVideo->getNome()} - <strong>Tipo: </strong> {$placaVideo->getTipo()} - <strong>Memória: </strong> {$placaVideo->getMemoria()} - <strong>Frequência: </strong> {$placaVideo->getFrequencia()}</p>
        <p style="display: {$exibirD}"> Leitores/Gravadores: {$driver->getID()} - {$driver->getNome()} - <strong>Velocidade: </strong>{$driver->getVelocidade()}</p>
        
         </div>
         </div>
</fieldset>

