<?php
$phpVersion = (float)phpversion();


if ($phpVersion >= 5.6) {
    require_once __DIR__. '/HELPER5_6.php';
} else {
    function ds($args) {
        foreach ($args as $a) {
            DebugUtil::show($a);
        }
    }

    /**
     * 
     */
    function dd($args) {
        foreach ($args as $a) {
            DebugUtil::show($a);
        }
        exit();
    }
}