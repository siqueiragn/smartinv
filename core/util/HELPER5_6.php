<?php

function ds(...$args) {
    foreach ($args as $a) {
        DebugUtil::show($a);
    }
}

/**
 * 
 */
function dd(...$args) {
    foreach ($args as $a) {
        DebugUtil::show($a);
    }
    exit();
}
