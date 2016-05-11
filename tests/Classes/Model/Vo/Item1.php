<?php

namespace SoulTest\Classes\Model\Vo;

use Soul\Model\Vo\Item;

class Item1 extends Item {

    protected $dataType = array(
        'id' => self::TYPE_INT,
        'string' => self::TYPE_STRING,
        'string1' => self::TYPE_STRING_MAX_1,
        'string255' => self::TYPE_STRING_MAX_255,
        'string50' => self::TYPE_STRING_MAX_50,
        'float' => self::TYPE_FLOAT,
        'bool' => self::TYPE_BOOL,
        'timestamp' => self::TYPE_TIMESTAMP,
        'decimal18_2' => self::TYPE_DECIMAL_18_2,
        'decimal18_4' => self::TYPE_DECIMAL_18_4,
        'list' => self::TYPE_LIST,
        'iterator' => self::TYPE_ITERATOR,
        'object' => self::TYPE_OBJECT,
        'text' => self::TYPE_TEXT,
        'method' => self::TYPE_STRING,
        'item' => self::TYPE_ITEM,
        'itemset' => self::TYPE_ITEMSET,
    );

    public function getMethod() {
        return $this->getInternal('method', true, null, false);
    }

    public function setMethod($method) {
        $this->data['method'] = $method;
    }

}