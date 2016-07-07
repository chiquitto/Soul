<?php

namespace Chiquitto\Soul\Util;

/**
 * @package Chiquitto\Soul\Util
 */
class Cpf extends AbstractCpfCnpj
{
    protected static $size = 11;

    protected static $modifiers = array(
        array(10, 9, 8, 7, 6, 5, 4, 3, 2),
        array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2)
    );
}