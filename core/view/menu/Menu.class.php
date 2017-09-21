<?php

/**
 * Description of Menu
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class Menu
{

    private $menuPrincipal = array();
    private $menuAuxiliar = array();
    private $logo;

    public function readerJson($file)
    {
        $root = json_decode($file);
        if (isset($root->menuPrincipal)) {
            $this->menuPrincipal = $root->menuPrincipal;
        }
        if (isset($root->menuAuxiliar)) {
            $this->menuAuxiliar = $root->menuAuxiliar;
        }
    }



    public function setLogo(MenuItem $logo)
    {
        $this->logo = $logo;
    }

    public function getLogo()
    {
        if ($this->logo) {
            return $this->logo;
        } else {
            return new MenuItem('', '');
        }
    }

    public function getMenuPrincipal()
    {
        return $this->menuPrincipal;
    }
    
    public function getMenuAuxiliar()
    {
        return $this->menuAuxiliar;
    }



}
