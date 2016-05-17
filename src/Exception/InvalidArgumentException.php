<?php

namespace Chiquitto\Soul\Exception;

/**
 * Lancado para parametros/valores de entrada invalidos de metodos
 */
class InvalidArgumentException extends Exception {

    protected $defaultCode = self::INVALID_ARGUMENT;
    protected $defaultMessage = 'Entrada invalida para o metodo';

}
