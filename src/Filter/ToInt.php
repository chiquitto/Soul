<?php

namespace Chiquitto\Soul\Filter;

use Zend\Filter\ToInt as ZendToInt;

/**
 * Description of ToInt
 *
 * @author alisson
 */
class ToInt extends ZendToInt {

    /**
     * 
     * @inheritdoc
     */
    public function filter($value) {
        $value = (string) $value;
        return (int) $value;
    }

}
