<?php

/**
 * Description of MenuItem
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class MenuItem
{
    private $label;
    private $action;
    private $type = 'html';
    private $function;
    
    public function __construct($label, $action)
    {
        $this->setLabel($label);
        $this->setAction($action);
    }
    
    public function getLabel()
    {
        return $this->label;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }


    
}
