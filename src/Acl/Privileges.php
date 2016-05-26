<?php

namespace Chiquitto\Soul\Acl;

/**
 * Description of Resources
 *
 * @author chiquitto
 */
class Privileges
{

    protected static $privilegesName = [];

    public static function getPrivilegesId()
    {
        return array_keys(static::$privilegesName);
    }

    public static function getPrivilegesName()
    {
        return static::$privilegesName;
    }

}
