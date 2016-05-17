<?php

namespace Chiquitto\Soul\Model\Vo;

use Iterator;
use Chiquitto\Soul\Model\Vo\Item;
use Chiquitto\Soul\Model\Vo\ValidatorItemset;

/**
 * Description of Itemset
 * Conjunto do mesmo tipo de objetos Item
 *
 * @author Alisson Chiquitto<chiquitto@chiquitto.com.br>
 */
abstract class Itemset implements Iterator
{

    protected $itensIndexed = [];
    protected $itens = [];
    protected $count = 0;

    public function rewind()
    {
        reset($this->itens);
    }

    /**
     * 
     * @return Item|null
     */
    public function current()
    {
        $var = current($this->itens);
        return $var;
    }

    /**
     * Retorna a chave do valor atual
     * @return int
     */
    public function key()
    {
        $var = key($this->itens);
        return $var;
    }

    /**
     * 
     * @return Item|null
     */
    public function next()
    {
        $var = next($this->itens);
        return $var;
    }

    /**
     * 
     * @return bool
     */
    public function valid()
    {
        $key = key($this->itens);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function add(Item $item)
    {
        $this->itens[] = $item;
        $this->count++;
    }

    public function addIndexed(Item $item, $id)
    {
        $this->itensIndexed[$id] = $item;
        $this->add($item);
    }

    /**
     * 
     * @param string|int $id
     * @return Item|null
     */
    public function getById($id)
    {
        return isset($this->itensIndexed[$id]) ? $this->itensIndexed[$id] : null;
    }

    public function set(Item $item, $key = NULL)
    {
        if (null === $key) {
            $key = $this->key();
        }
        $this->itens[$key] = $item;
    }

    public function clear()
    {
        $this->itens = array();
        $this->count = 0;
    }

    /**
     * 
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * 
     * @param int $type
     * @param array $options
     * @return array
     */
    public function getAll($type = Item::GETALL_ARRAY, array $options = array())
    {
        $r = array();

        foreach ($this->itens as $item) {
            $r[] = $item->getAll($type, $options);
        }

        return $r;
    }

    /**
     * 
     * @return ValidatorItemset
     */
    public function newValidateItemset()
    {
        return new ValidatorItemset();
    }

}
