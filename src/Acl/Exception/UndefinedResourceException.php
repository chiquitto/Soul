<?php

namespace Chiquitto\Soul\Acl\Exception;

/**
 * Class UndefinedResourceException
 * @codeCoverageIgnore
 * @package Chiquitto\Soul\Acl\Exception
 */
class UndefinedResourceException extends Exception
{

    protected $defaultCode = self::UNDEFINED_RESOURCE;
    protected $defaultMessage = 'Undefined resource.';

}
