<?php

namespace Chiquitto\Soul\Test;

use Chiquitto\Soul\Util\ServiceLocatorFactory;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Zend\Db\Sql\Ddl\Column;
use Zend\Db\Sql\Ddl\Constraint;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Sql;

class TestCase extends PHPUnit_Framework_TestCase
{

    protected static $preparedDb = false;

    private function createTables()
    {
        $this->createTbconfig();
    }

    private function createTbconfig()
    {
        $table = new CreateTable('tbconfig');
        $table->addColumn(new Column\Varchar('idconfig'));
        $table->addColumn(new Column\Varchar('stvalue', 255, true));
        $table->addColumn(new Column\Text('sttext', null, true));
        $table->addConstraint(new Constraint\PrimaryKey('idconfig'));

        $adapter = ServiceLocatorFactory::getInstance()->get('Zend\Db\Adapter\Adapter');
        $sql = new Sql($adapter);

        $adapter->query(
            $sql->buildSqlString($table),
            $adapter::QUERY_MODE_EXECUTE
        );
    }

    private function dropDatabase()
    {
        $file = ServiceLocatorFactory::getConfiguration()['db']['database'];
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Call protected/private method of a class.
     *
     * @link https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function prepareDb($useCache = true)
    {
        if (!self::$preparedDb) {
            $this->dropDatabase();
            $this->createTables();
        }

        self::$preparedDb = true;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->prepareDb();
    }


}
