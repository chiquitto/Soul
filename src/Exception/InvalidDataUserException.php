<?php

namespace Chiquitto\Soul\Exception;

/**
 * Lancado quando dados que o usuario forneceu sao invalidos
 */
class InvalidDataUserException extends Exception {

    protected $defaultCode = self::INVALID_DATA_USER;
    protected $defaultMessage = 'Dados invalidos fornecidos pelo usuario';
    
}
