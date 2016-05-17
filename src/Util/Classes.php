<?php

namespace Chiquitto\Soul\Util;

/**
 * Description of Classes
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Classes {

    /**
     * Return the short class name (Name without namespace)
     * Ex.: shortName(Chiquitto\Soul\Util\Classes) => Classes
     * 
     * @link http://php.net/manual/pt_BR/function.get-class.php
     * @param string $classname
     * @return string
     */
    public static function shortName($classname) {
        if ($pos = strrpos($classname, '\\')) {
            return substr($classname, $pos + 1);
        }
        return $classname;
    }

}
