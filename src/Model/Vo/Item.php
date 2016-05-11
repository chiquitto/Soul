<?php

namespace Soul\Model\Vo;

use Soul\Exception\InvalidArgumentException;
use Exception;
use Iterator;
use stdClass;

/**
 * Classe para armazenar valores.
 * O objetivo desta classe nao eh fazer validacoes, apenas armazenar conforme o tipo do valor.
 * Representa um registro de uma tabela.
 *
 * @author alisson
 */
abstract class Item {

    /**
     * Define o retorno como array
     */
    const GETALL_ARRAY = 1001;

    /**
     * Define o retorno como um stdClass
     */
    const GETALL_STDCLASS = 1002;
    const TYPE_STRING = 1001;
    const TYPE_STRING_MAX_1 = 1002;
    const TYPE_STRING_MAX_255 = 1003;
    const TYPE_STRING_MAX_50 = 1004;
    const TYPE_INT = 1101;
    const TYPE_FLOAT = 1102;
    const TYPE_BOOL = 1201;
    const TYPE_TIMESTAMP = 1301;

    /**
     * Utilizado para tipos timestamp
     */
    const TYPE_DATETIME = 1302;
    const TYPE_DECIMAL_18_2 = 1401;
    const TYPE_DECIMAL_18_4 = 1402;

    /**
     * Lista com valores simples
     */
    const TYPE_LIST = 1501;

    /**
     * Lista com valores complexos
     */
    const TYPE_ARRAY = 1502;
    const TYPE_ITERATOR = 1601;
    const TYPE_ITEMSET = 1602;
    const TYPE_OBJECT = 1701;
    const TYPE_ITEM = 1702;
    const TYPE_TEXT = 1801;

    protected $data = array();
    protected $dataType = array();
    protected $table;
    protected $tablePk;
    protected $validateItem = null;

    public function __construct($data = null, $options = null) {
        if ((is_array($data)) || ($data instanceof stdClass)) {
            $this->populate($data);
        }
    }

    public function __call($name, $arguments) {
        $part1 = substr($name, 0, 3);
        if (($part1 == 'set') or ( $part1 == 'get')) {
            $part2 = substr($name, 3);
            if ($part1 == 'set') {
                $this->set(lcfirst($part2), $arguments[0]);
                return;
            } else {
                return $this->get(lcfirst($part2));
            }
        }

        throw new InvalidArgumentException('Method ' . self::class . '::' . $name . '() not found');
    }

    public function clearData() {
        $this->data = array();
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function __isset($name) {
        return array_key_exists($name, $this->data);
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

    /**
     * Retorna o valor de um atributo.
     *
     * @param string $name
     * @param boolean $throwException
     * @param mixed $default
     * @param boolean $callMethod
     * @return mixed
     * @throws Exception
     */
    public function get($name, $throwException = true, $default = null) {
        return $this->getInternal($name, $throwException, $default, true);
    }

    /**
     * Retorna os dados em formato array|\stdClass
     *
     * @param int $type Formato do retorno
     * @param array $options
     * @return array|stdClass
     */
    public function getAll($type = self::GETALL_ARRAY, array $options = array()) {
        $options['onlyFilled'] = true;
        return $this->getAllValues($type, $options);
    }

    private function getAllItem($type, $value, array $options) {
        if ($value instanceof Item) {
            return $value->getAll($type, $options);
        } elseif ($value instanceof Itemset) {
            return $value->getAll($type, $options);
        } else {
            return $value;
        }
    }

    public function getAllValues($type = self::GETALL_ARRAY, array $options = array()) {
        if ((isset($options['onlyFilled'])) && ($options['onlyFilled'])) {
            $dataKeys = array_keys($this->data);
        } else {
            $dataKeys = array_keys($this->dataType);
        }

        if (isset($options['ignore'])) {
            $dataKeys = array_values(array_diff($dataKeys, $options['ignore']));
        }

        $data = array();
        $iMax = count($dataKeys);
        for ($i = 0; $i < $iMax; $i++) {
            $optionsInner = isset($options[$dataKeys[$i]]) ? $options[$dataKeys[$i]] : array();
            $data[$dataKeys[$i]] = $this->getAllItem($type, $this->get($dataKeys[$i]), $optionsInner);
        }

        switch ($type) {
            case self::GETALL_STDCLASS:
                return (object) $data;
                break;

            default:
                return $data;
                break;
        }
    }

    public function getTablePkVal() {
        if (!$this->tablePk) {
            throw new InvalidArgumentException('Undefined tablePk (' . get_class($this) . ')');
        }

        return $this->get($this->tablePk);
    }

    /**
     * Retorna um valor de $this->data.
     * Permite cancelar a chamada do metodo get do atributo.
     * 
     * @param string $name
     * @param boolean $throwException
     * @param mixed $default
     * @param boolean $callMethod
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function getInternal($name, $throwException = true, $default = null, $callMethod = true) {
        if ($callMethod) {
            $method = 'get' . ucfirst($name);
            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }

        if ((!array_key_exists($name, $this->dataType)) && ($throwException)) {
            throw new InvalidArgumentException("Unknown field $name in " . self::class);
        }

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return $default;
    }

    public function getTable() {
        return $this->table;
    }

    public function getTypes() {
        return $this->dataType;
    }

    /**
     * Retorna um novo ValidateItem e atribui para o Vo
     * 
     * @return ValidatorItem
     */
    public function newValidateItem() {
        return $this->validateItem = new ValidatorItem();
    }

    public function populate($data) {
        foreach ($data as $k => $v) {
            if (!isset($this->dataType[$k])) {
                continue;
            }
            $this->set($k, $v);
        }
    }

    public function set($name, $value) {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } elseif (!isset($this->dataType[$name])) {
            throw new InvalidArgumentException("Unknown type for field $name in " . get_class($this));
        } elseif (null !== $value) {
            switch ($this->dataType[$name]) {
                case self::TYPE_STRING:
                case self::TYPE_TEXT:
                    if (!is_string($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an string");
                    }
                    break;

                case self::TYPE_STRING_MAX_1:
                    if (!is_string($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an string");
                    }
                    $value = substr((string) $value, 0, 1);
                    break;

                case self::TYPE_STRING_MAX_255:
                    if (!is_string($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an string");
                    }
                    $value = substr((string) $value, 0, 255);
                    break;

                case self::TYPE_STRING_MAX_50:
                    if (!is_string($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an string");
                    }
                    $value = substr((string) $value, 0, 50);
                    break;

                case self::TYPE_INT:
                case self::TYPE_TIMESTAMP:
                    if (!is_int($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt a integer");
                    }
                    break;

                case self::TYPE_FLOAT:
                    if (!is_float($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt a float");
                    }
                    break;

                case self::TYPE_BOOL:
                    if (!is_bool($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt a boolean");
                    }
                    break;

                case self::TYPE_DECIMAL_18_2:
                    if (!is_float($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt a float");
                    }
                    $value = round($value, 2, PHP_ROUND_HALF_DOWN);
                    break;

                case self::TYPE_DECIMAL_18_4:
                    if (!is_float($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt a float");
                    }
                    $value = round($value, 4, PHP_ROUND_HALF_DOWN);
                    break;

                case self::TYPE_LIST:
                    if (!is_array($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an array");
                    }
                    break;

                case self::TYPE_OBJECT:
                    if (!is_object($value)) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an object");
                    }
                    break;

                case self::TYPE_ITERATOR:
                    if (!$value instanceof Iterator) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an Iterator object");
                    }
                    break;

                case self::TYPE_ITEM:
                    if (!$value instanceof self) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an Item object");
                    }
                    break;

                case self::TYPE_ITEMSET:
                    if (!$value instanceof Itemset) {
                        throw new InvalidArgumentException("Value for field ($name) isnt an Itemset object");
                    }
                    break;
            }
        }
        $this->data[$name] = $value;
    }

}
