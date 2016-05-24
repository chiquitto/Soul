<?php

namespace Chiquitto\Soul\Acl\Adapter\Exception;

class UndefinedResourceException extends Exception
{

    protected $defaultCode = self::UNDEFINED_RESOURCE;
    protected $defaultMessage = 'Recurso indefinido.';

}
