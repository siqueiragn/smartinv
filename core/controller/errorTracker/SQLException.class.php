<?php

/**
 * Exceção gerada pelas classes de acesso ao banco de dados.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package core.controller.errorTracker
 * @version 1.0.0
 */
class SQLException extends Exception
{

    /**
     *
     * @var String SQL que deveria ser executada 
     */
    private $query;

    /**
     *
     * @var array 
     */
    private $prepared = null;

    /**
     * 
     * @param Exception $e
     * @param String $query
     * @param Array $prepared
     */
    public function __construct(Exception $e, $query, $prepared = null)
    {
        parent::__construct($e->getMessage());
        $this->query = $query;
        if ($prepared !== null) {
            $this->prepared = $prepared;
        }
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function getPrepared()
    {
        return $this->prepared;
    }

    public function setPrepared($prepared)
    {
        $this->prepared = $prepared;
        return $this;
    }

}
