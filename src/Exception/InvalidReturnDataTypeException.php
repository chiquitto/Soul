<?php

namespace Chiquitto\Soul\Exception;

class InvalidReturnDataTypeException extends Exception {
    protected $defaultCode = self::INVALID_RETURN_DATATYPE;
    protected $defaultMessage = 'Foi encontrado um tipo inesperado para o retorno de um metodo';
}
