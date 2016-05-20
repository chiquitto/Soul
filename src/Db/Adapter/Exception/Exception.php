<?php

namespace Chiquitto\Soul\Db\Adapter\Exception;

use Chiquitto\Soul\Exception\Exception as SoulException;

class Exception extends SoulException {

    private $sql;

    /**
     *
     * @var array
     */
    private $params = [];

    /**
     *
     * @var \Chiquitto\Soul\Model\Vo\Item
     */
    private $item;

    public function __toString() {
        $out = "SQL: {$this->sql}\n";
        $out .= "Params: " . print_r($this->params, 1) . "\n";

        if ($this->item instanceof \Chiquitto\Soul\Model\Vo\Item) {
            $out .= "Item: " . print_r($this->item->getAll(), 1) . "\n";
        }

        return $out; // . parent::__toString();
    }

    public function getSql() {
        return $this->sql;
    }

    public function getParams() {
        return $this->params;
    }

    public function getItem() {
        return $this->item;
    }

    public function setSql($sql) {
        $this->sql = $sql;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function setItem(\Chiquitto\Soul\Model\Vo\Item $item) {
        $this->item = $item;
    }

}
