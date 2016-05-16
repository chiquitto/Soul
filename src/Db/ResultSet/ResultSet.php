<?php

namespace Soul\Db\ResultSet;

use Zend\Db\ResultSet\ResultSet as ZendResultSet;

/**
 * Description of ResultSet
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class ResultSet extends ZendResultSet {

    public function toArrayAssoc($key, $value = null) {
        $r = [];

        if (is_array($value)) {
            $iCount = count($value);
        }

        foreach ($this as $row) {
            /* @var $row ArrayObject */

            if (null === $value) {
                $add = $row;
            } elseif (is_array($value)) {
                $add = array();
                for ($i = 0; $i < $iCount; $i++) {
                    $add[$value[$i]] = $row[$value[$i]];
                }
            } else {
                $add = $row[$value];
            }

            if (null === $key) {
                $r[] = $add;
            } else {
                $r[$row[$key]] = $add;
            }
        }

        return $r;
    }

}
