<?php

namespace Soul\Db\TableGateway;

use Soul\Db\Adapter\Adapter;
use Soul\Db\Adapter\AdapterInterface;
use Soul\Db\Adapter\AdapterWrite;
use Soul\Db\ResultSet\ResultSet;
use Soul\Exception\InvalidArgumentException;
use Soul\Util\ServiceLocatorFactory;

/**
 * @codeCoverageIgnore
 */
class TableGatewayFactory {

    const MODE_READ = 'READ';
    const MODE_WRITE = 'WRITE';
    
    protected static $defaultAdapterRead;
    protected static $defaultAdapterWrite;
    protected static $pkName = array();
    protected static $tableClasses = array();
    protected static $tableNames = array();

    /**
     * Retorna uma instancia de um Gateway para uma das tabelas do BD
     * 
     * @param string $tableGatewayName
     * @return TableGateway
     */
    protected static function factory($tableGatewayName, $method = self::MODE_READ, array $options = array()) {
        if ($method === null) {
            $method = self::MODE_READ;
        }
        
        if (isset(static::$tableClasses[$tableGatewayName])) {
            return self::factoryClass(static::$tableClasses[$tableGatewayName], $method);
        } elseif (isset(static::$tableNames[$tableGatewayName])) {
            return self::factoryTableGateway(static::$tableNames[$tableGatewayName], $method);
        }

        throw new InvalidArgumentException("Tabela invalida");
    }

    /**
     * Instancia uma classe que estende TableGateway.
     * 
     * @param string $className
     * @param string $method
     * @return TableGateway
     */
    public static function factoryClass($className, $method = self::MODE_READ) {
        return new $className(null, self::getDefaultDbAdapter($method));
    }

    /**
     * 
     * @param string $tableGatewayName
     * @return TableGateway
     */
    public static function factoryRead($tableGatewayName) {
        return self::factory($tableGatewayName, self::MODE_READ);
    }

    /**
     * Cria uma instancia de TableGateway
     * 
     * @param string $tableName
     * @param string $method
     * @return TableGateway
     */
    public static function factoryTableGateway($tableName, $method = self::MODE_READ) {
        return static::factoryTableGatewayInternal($tableName, self::getDefaultDbAdapter($method));
    }

    /**
     * 
     * @param string $tableName
     * @param AdapterInterface $adapter
     * @return TableGateway
     */
    protected static function factoryTableGatewayInternal($tableName, AdapterInterface $adapter) {
        return new TableGateway($tableName, $adapter, null, new ResultSet());
    }

    /**
     * 
     * @param string $tableGatewayName
     * @return TableGateway
     */
    public static function factoryWrite($tableGatewayName) {
        return self::factory($tableGatewayName, self::MODE_WRITE);
    }

    /**
     * 
     * @param type $method
     * @return Adapter
     */
    public static function getDefaultDbAdapter($method) {
        if ($method == self::MODE_WRITE) {
            return self::getDefaultDbAdapterWrite();
        }

        return self::getDefaultDbAdapterRead();
    }

    /**
     * Retorna o adaptador para Select
     * 
     * @return Adapter
     */
    public static function getDefaultDbAdapterRead() {
        if (!self::$defaultAdapterRead) {
            self::$defaultAdapterRead = ServiceLocatorFactory::getInstance()->get('Zend\Db\Adapter\Adapter');
        }
        return self::$defaultAdapterRead;
    }

    /**
     * Retorna o adaptador para SQLs de Insert/Update/Delete
     * 
     * @return AdapterWrite
     */
    public static function getDefaultDbAdapterWrite() {
        if (!self::$defaultAdapterWrite) {
            // self::$defaultAdapterWrite = ServiceLocatorFactory::getInstance()->get('Zend\Db\Adapter\AdapterWrite');
            self::$defaultAdapterWrite = ServiceLocatorFactory::getInstance()->get('Zend\Db\Adapter\AdapterWrite');
        }
        return self::$defaultAdapterWrite;
    }

    public static function getPkName($tableName) {
        return static::$pkName[$tableName];
    }

    /**
     * 
     * @param Adapter $defaultAdapter
     */
    public static function setDefaultDbAdapterRead(AdapterInterface $defaultAdapter) {
        self::$defaultAdapterRead = $defaultAdapter;
    }

    /**
     * 
     * @param AdapterWrite $defaultAdapter
     */
    public static function setDefaultDbAdapterWrite(AdapterInterface $defaultAdapter) {
        self::$defaultAdapterWrite = $defaultAdapter;
    }

}
