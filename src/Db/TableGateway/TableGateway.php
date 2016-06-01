<?php

namespace Chiquitto\Soul\Db\TableGateway;

use ArrayObject;
use Chiquitto\Soul\Db\Adapter\Adapter;
use Chiquitto\Soul\Db\Sql\Upsert;
use Closure;
use Exception;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\Pdo\Statement;
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

    /**
     * 
     * @param int $timestamp
     * @return string
     */
    public function timestamp2Bd($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return date('Y-m-d H:m:s', $timestamp);
    }
    
    public function upsert($set, array $keys)
    {
        // delete and insert
        
        $upsert = new Upsert($this->table);
        $upsert->setUpdateFieldStatements($set);
        $upsert->values($keys + $set);
        
        $statement = $this->sql->prepareStatementForSqlObject($upsert);
        $result = $statement->execute();
        
        //$sql = $upsert->getSqlString($this->getAdapter()->getPlatform());
        //$query = $this->getAdapter()->query($sql);
        //$query->execute();
        
        return true;
        
        $values = $keys + $set;
        
        $insert = $this->sql->insert();
        $insert->values($values);
        
        $sql = $insert->getSqlString($this->getAdapter()->getPlatform());
        $sql .= " ON DUPLICATE KEY ";
        
        $update = $this->sql->update();
        $update->set($set);
        
        $set = [];
        foreach ($update->getRawState('set') as $field => $value) {
            $set[] = $this->adapter->getPlatform()->quoteIdentifier($field) . " = " . $this->adapter->getPlatform()->quoteValue($value);
        }
        
        $sql .= join(", ", $set);
        
        /* @var $query Statement */
        $query = $this->adapter->query($sql);
        $query->execute();
        
        //$sql = "INSERT INTO sometable (id, col2, col3) VALUES (:id, :col2, :col3) ON DUPLICATE KEY UPDATE col2 = VALUES(col2), col3 = VALUES(col3)";
    }

}
