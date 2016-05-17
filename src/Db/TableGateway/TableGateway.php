<?php

namespace Chiquitto\Soul\Db\TableGateway;

use ArrayObject;
use Closure;
use Chiquitto\Soul\Db\Adapter\Adapter;
use Exception;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway as ZendTableGateway;

/**
 * @codeCoverageIgnore
 */
class TableGateway extends ZendTableGateway {

    /**
     * Retorna uma instancia de TableGateway
     * 
     * @param string $tableName
     * @param AdapterInterface $adapter
     * @return TableGateway
     */
    public static function factoryTableGateway($tableName, AdapterInterface $adapter) {
        return new self($tableName, $adapter);
    }

    /**
     * 
     * @param Where|Closure|string|array $where
     * @return ArrayObject
     */
    public function findRow($where) {
        return $this->select($where)->current();
    }
    
    /**
     * 
     * @return Adapter
     */
    public function getAdapter() {
        return parent::getAdapter();
    }

    public function getDateTime2Bd($time = null) {
        if ($time === null) {
            $time = time();
        }
        return date('c', $time);
    }

    /**
     * @link http://stackoverflow.com/questions/17447311/zendframework-2-select-max-of-a-column
     * @param type $column
     * @param type $where
     * @return type
     * @throws Exception
     */
    public function max($column, $where = null) {
        $select = $this->getSql()->select();
        $select->columns(array(
            'm' => new Expression("MAX($column)")
        ));

        if ($where) {
            $select->where($where);
        }

        $rowset = $this->selectWith($select);
        $row = $rowset->current();

        return $row->m;
    }

}
