<?php

namespace Chiquitto\Soul\Db\Sql;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\DriverInterface;
use Zend\Db\Adapter\ParameterContainer;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Adapter\StatementContainerInterface;
use Zend\Db\Exception\InvalidArgumentException;
use Zend\Db\Sql\Insert;

/**
 * @link https://coding-on-my-mind.com/1/zf2-php-mysql-upsert-update-on-duplicate-key
 * @codeCoverageIgnore
 */
class Upsert extends Insert {
    /*     * #@+
     * Constants
     *
     * @const
     */

    const SPECIFICATION_UPSERT = 'upsert';

    /*     * #@- */

    /**
     * @var array Specification array
     */
    protected $specifications = [
        self::SPECIFICATION_UPSERT => 'INSERT INTO %1$s (%2$s) VALUES (%3$s) ON DUPLICATE KEY UPDATE %4$s',
    ];

    /**
     * we store all fields should be updated if key is already in
     * database and the corresponding statement in this array
     *
     * @var array
     */
    protected $updateFieldStatement = array();

    /**
     * we store all fields and the corresponding statement we want
     * to update "ON DUPLICATE KEY". It is fairly easy to do this, you can
     * just refer to the values in the INSERT part:
     * ON DUPLICATE KEY UPDATE updated_on = VALUES(updated_on), value = VALUES(value)
     *
     * As we usually add values to existing values we do not just provide the
     * name of the field but also the statement we want to execute, e.g.
     * $fieldStatments = array(
     *   'charField' => 'CONCAT("abc", VALUES(charField)',
     *   'intField'  => 'intField + VALUES(intField)',
     * )
     *
     * @param array $fieldStatments
     */
    public function setUpdateFieldStatements(array $fieldStatments) {

        $this->updateFieldStatement = $fieldStatments;
    }

    /**
     * @todo exec processUpsert
     * @param PlatformInterface $adapterPlatform
     * @return string
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function getSqlString(PlatformInterface $adapterPlatform = null) {
        
        throw new Exception(__METHOD__ . ' nao implementado');

        if (0 === count($this->updateFieldStatement)) {
            // we need (in contradiction to a normal INSERT the fields and
            // the statements we want to have in an UPDATE case
            throw new InvalidArgumentException('no arguments for insert fields given');
        }

        $sqlString = parent::getSqlString($adapterPlatform);

        $updateStatements = array();
        foreach ($this->updateFieldStatement AS $key => $value) {
            $updateStatements[] = $adapterPlatform->quoteIdentifier($key) . ' = ' . $value;
        }

        $sqlString .= ' ON DUPLICATE KEY UPDATE ' . join(', ', $updateStatements);

        return $sqlString;
    }

    protected function processUpsert(PlatformInterface $platform, DriverInterface $driver = null, ParameterContainer $parameterContainer = null) {
        if (!$this->columns) {
            throw new Exception\InvalidArgumentException('values or select should be present');
        }

        $columns = [];
        $values = [];
        $updates = [];

        foreach ($this->columns as $column => $value) {
            $columns[$column] = $platform->quoteIdentifier($column);
            if (is_scalar($value) && $parameterContainer) {
                $values[$column] = $driver->formatParameterName($column);
                $parameterContainer->offsetSet($column, $value);
            } else {
                $values[$column] = $this->resolveColumnValue(
                        $value, $platform, $driver, $parameterContainer
                );
            }

            if (array_key_exists($column, $this->updateFieldStatement)) {
                $updates[] = "{$columns[$column]} = {$values[$column]}";
            }
        }
        return sprintf(
                $this->specifications[static::SPECIFICATION_UPSERT],
                $this->resolveTable($this->table, $platform, $driver, $parameterContainer),
                implode(', ', $columns),
                implode(', ', $values),
                implode(', ', $updates)
        );
    }

}
