<?php

namespace Chiquitto\Soul\Db\Adapter;

use Chiquitto\Soul\Exception\Exception;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Adapter\Profiler\ProfilerInterface;
use Zend\Db\ResultSet\ResultSetInterface;

/**
 * Description of ProfilingAdapter
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @codeCoverageIgnore
 */
class AdapterDdl extends Adapter {

    public function __construct($driver, PlatformInterface $platform = null, ResultSetInterface $queryResultPrototype = null, ProfilerInterface $profiler = null) {
        parent::__construct($driver, $platform, $queryResultPrototype, $profiler);
    }

    public function beginTransaction() {
        throw new Exception('BEGIN nao suportado em leituras');
    }

    public function commit() {
        throw new Exception('COMMIT nao suportado em leituras');
    }

    //public function injectProfilingStatementPrototype(array $options = array()) {
    // metodo sobrescrito para desabilitar o profilling em query->execute()
    //}

    public function rollback() {
        throw new Exception('ROLLBACK nao suportado em leituras');
    }

}
