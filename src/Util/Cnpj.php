<?php

namespace Chiquitto\Soul\Util;

/**
 * @package Chiquitto\Soul\Util
 */
class Cnpj extends AbstractCpfCnpj
{
    protected static $size = 14;

    protected static $modifiers = array(
        array(5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2),
        array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2)
    );
}