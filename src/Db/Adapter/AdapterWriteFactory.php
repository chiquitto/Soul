<?php

namespace Soul\Db\Adapter;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ProfilingAdapterFactory
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html
 * @return AdapterWrite
 */
class AdapterWriteFactory extends AdapterFactory {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        $dbParams = $config['db'];

        if ($config['dinazendDbProfiler']) {
            return new ProfilingWriteAdapter($dbParams);
        } else {
            // @codeCoverageIgnoreStart
            return new Adapter($dbParams);
            // @codeCoverageIgnoreEnd
        }
    }

}
