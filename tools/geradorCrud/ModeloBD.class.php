<?php

/**
 * Description of Model
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 * @package
 */
class ModeloBD extends AbstractModel
{
    public function __construct($dbName = DB_NAME,
                                    $server = DB_SERVER, 
                                    $user = DB_USER, 
                                    $pass = DB_PASSWORD)
    {
        parent::__construct($dbName, $server, $user, $pass);
    }

    public function resultadoAssoc($result)
    {
        return $result->fetch();
    }
}
