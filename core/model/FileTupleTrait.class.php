<?php
namespace core\model;

/**
 * Description of FileTupleTrait
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
trait  FileTupleTrait
{
    public function geraNome(){
        return  md5(uniqid(rand(), true));
    }
}
