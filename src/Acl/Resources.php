<?php

namespace Chiquitto\Soul\Acl;

use Chiquitto\Soul\Acl\Exception\UndefinedResourceException;

/**
 * Description of Resources
 *
 * @author chiquitto
 */
class Resources
{
    
    protected static $extendedResources = [];
    protected static $resources = [];

    public static function getResource($idresource)
    {
        if (isset(static::$extendedResources[$idresource])) {
            $idresource = static::$extendedResources[$idresource];
        }
        
        if (!isset(static::$resources[$idresource])) {
            throw new UndefinedResourceException("Undefined $idresource resource");
        }
        
        return isset(static::$resources[$idresource]) ? static::$resources[$idresource] : null;
    }

    public static function getResourceRules($idresource)
    {
        $resource = static::getResource($idresource);
        return $resource['rules'];
    }

}
