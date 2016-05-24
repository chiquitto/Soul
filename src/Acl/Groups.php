<?php

namespace Chiquitto\Soul\Acl;

/**
 * Description of Groups
 *
 * @author chiquitto
 */
class Groups
{

    private static $groupName = [];
    private static $groups = [];

    public static function getGroups()
    {
        return static::$groups;
    }

    public static function getGroupName($key)
    {
        return static::$groupName[$key];
    }

    public static function getGroupsName()
    {
        return static::$groupName;
    }

    public static function getPrivilegesIdByGroupId($idgroup)
    {
        return static::$groups[$idgroup];
    }

}
