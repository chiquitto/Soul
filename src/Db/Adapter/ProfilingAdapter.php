<?php

namespace Soul\Db\Adapter;

use BjyProfiler\Db\Adapter\ProfilingAdapter as BjyProfilerProfilingAdapter;
use BjyProfiler\Db\Profiler\LoggingProfiler;
use BjyProfiler\Db\Profiler\Profiler;
use Soul\Util\ServiceLocatorFactory;
use Exception;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Adapter\Profiler\ProfilerInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Description of ProfilingAdapter
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @codeCoverageIgnore
 */
class ProfilingAdapter extends BjyProfilerProfilingAdapter implements AdapterInterface {

    public function __construct($driver, PlatformInterface $platform = null, ResultSetInterface $queryResultPrototype = null, ProfilerInterface $profiler = null) {
        parent::__construct($driver, $platform, $queryResultPrototype, $profiler);

        $this->loadProfiler();
    }

    protected function loadProfiler() {
        $config = ServiceLocatorFactory::getConfiguration();

        $dbParams = $config['db'];

        if ($config['dinazendDbProfiler']['type'] == 'file') {
            if (!is_file($config['dinazendDbProfiler']['file'])) {
                fclose(fopen($config['dinazendDbProfiler']['file'], 'a'));
            }
            
            $logger = new Logger();
            // write queries profiling info to stdout in CLI mode
            $writer = new Stream($config['dinazendDbProfiler']['file']);
            $logger->addWriter($writer, Logger::DEBUG);
            $this->setProfiler(new LoggingProfiler($logger));
        } elseif (php_sapi_name() == 'cli') {
            $logger = new Logger();
            // write queries profiling info to stdout in CLI mode
            $writer = new Stream('php://output');
            $logger->addWriter($writer, Logger::DEBUG);
            $this->setProfiler(new LoggingProfiler($logger));
        } else {
            $this->setProfiler(new Profiler());
        }
        
        if (isset($dbParams['options']) && is_array($dbParams['options'])) {
            $options = $dbParams['options'];
        } else {
            $options = array();
        }
        $this->injectProfilingStatementPrototype($options);
        
        return $this;
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
