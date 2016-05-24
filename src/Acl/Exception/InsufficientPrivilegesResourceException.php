<?php

namespace Chiquitto\Soul\Acl\Adapter\Exception;

class InsufficientPrivilegesResourceException extends Exception
{

    protected $defaultCode = self::INSUFFICIENT_PRIVILEGE_RESOURCE;
    protected $defaultMessage = 'Privilégios insuficientes para o recurso.';

}
