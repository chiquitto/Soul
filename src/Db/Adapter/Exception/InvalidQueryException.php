<?php

namespace Chiquitto\Soul\Db\Adapter\Exception;

class InvalidQueryException extends Exception
{

    protected $defaultCode = self::INVALID_QUERY;
    protected $defaultMessage = 'Foi encontrado um erro inesperado ao processar uma instrução.';

}
