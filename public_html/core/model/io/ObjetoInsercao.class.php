<?php
namespace core\model\io;
/**
 * Interface que determina os métodos necessários para a manipulação de objetos no 
 * banco de dados.
 * 
 * FIXME - transformar em um objeto manipulavel 
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.1.0
 */
interface ObjetoInsercao {
    
    /**
     * @return String - código que deve ser passado no campo de insercao do sql
     */
    public function codigoInsercao();
}
