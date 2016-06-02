<?php

namespace Chiquitto\Soul\Util;

/**
 * Description of String
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Arrays {

    /**
     * Prepare an array to be used as input params.
     * Ex.: Convert the array
     * [
     *   'id'   =>  10,
     *   'name' => 'fred'
     * ]
     * to
     * [
     *   '{id}'   =>  10,
     *   '{name}' => 'fred'
     * ]
     * 
     * @param array $params
     * @param string $prefix
     * @param string $suffix
     * @return array
     */
    public static function prepareParams(array $params = [], $prefix = '{', $suffix = '}') {
        if (!$params) {
            return $params;
        }

        $r = [];
        foreach ($params as $paramName => $paramValue) {
            $r[$prefix . $paramName . $suffix] = $paramValue;
        }
        return $r;
    }


}
