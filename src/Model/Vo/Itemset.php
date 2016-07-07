<?php

namespace Chiquitto\Soul\Model\Vo;

use Iterator;

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
     * @return Item|null
     */
    public function current()
    {
        $var = current($this->itens);
        return $var;
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
     * @param string|int $id
     * @return Item|null
     */
    public function getByIndentifiedPos($id)
    {
        return isset($this->itensIndexed[$id]) ? $this->itensIndexed[$id] : null;
    }

    public function getRandom()
    {
        return $this->itens[mt_rand(0, $this->count() - 1)];
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
     * @return ValidatorItemset
     */
    public function newValidateItemset()
    {
        return new ValidatorItemset();
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

    public function rewind()
    {
        reset($this->itens);
    }

    public function set(Item $item, $key = NULL)
    {
        if (null === $key) {
            $key = $this->key();
        }
        $this->itens[$key] = $item;
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

}
