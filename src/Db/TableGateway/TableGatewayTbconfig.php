<?php

namespace Soul\Db\TableGateway;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Sql;

/**
 * Description of TableGatewayConfig
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class TableGatewayTbconfig extends TableGateway {

    protected $tableName = 'tbconfig';

    public function __construct($table, AdapterInterface $adapter, $features = null, ResultSetInterface $resultSetPrototype = null, Sql $sql = null) {
        parent::__construct($this->tableName, $adapter, $features, $resultSetPrototype, $sql);
    }

}
