<?php

namespace Chiquitto\Soul\Underscore;

use Closure;
use Iterator;
use Underscore\Types\Arrays as UnderscoreArrays;

/**
 * Description of Arrays
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Arrays extends UnderscoreArrays {

    /**
     * Itera sobre um iterator mas retorna um array
     * 
     * @param Iterator $iterator
     * @param Closure $closure
     * @return array
     */
    public static function eachIterator(Iterator $iterator, Closure $closure) {
        $r = [];
        
        foreach ($iterator as $key => $value) {
            $r[$key] = $closure($value, $key);
        }

        return $r;
    }

}
