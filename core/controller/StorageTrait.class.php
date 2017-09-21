<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\controller;


trait StorageTrait{
    
    public function add($key, $value){
        if(is_object($value)){
            $_SESSION['storage'][$key]['obj'] = serialize($value);
        }if(is_array($value)){
            $_SESSION['storage'][$key]['array'] = $value;
        }else{
            $_SESSION['storage'][$key] = $value;
        }
    }
    
    public function get($key){
        if(isset($_SESSION['storage']['key'])){
            return $_SESSION['storage']['key'];
        }        
        return null;
    }
    
    public function del($key){
        unset($_SESSION['storage']['key']);
    }
    
}