<?php
/**
 * Description of LibException
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class LibException extends Exception {

    public function __construct($message) {
        parent::__construct($message,1, 2);
    }

}
