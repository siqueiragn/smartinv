<?php



/**
 * Classe de transição entre o siabase e enyalius core.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 * @deprecated since version 1
 */
class Modelo extends AbstractModel
{
    public function ativaDebug(){
        $this->db->debugOn();
    }
    
    public function resultadoAssoc($result)
    {
        parent::resultAssoc($result);
    }
}
