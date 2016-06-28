<?php

namespace Chiquitto\Soul\Acl\Exception;

/**
 * Class InsufficientPrivilegesResourceException
 * @codeCoverageIgnore
 * @package Chiquitto\Soul\Acl\Exception
 */
class InsufficientPrivilegesResourceException extends Exception
{

    protected $defaultCode = self::INSUFFICIENT_PRIVILEGE_RESOURCE;
    protected $defaultMessage = 'Privilégios insuficientes para o recurso.';

}
