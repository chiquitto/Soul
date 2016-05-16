<?php

namespace Soul\Db\Adapter;

use BjyProfiler\Db\Adapter\ProfilingAdapterFactory as BjyProfilerProfilingAdapterFactory;
use Soul\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ProfilingAdapterFactory
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html
 * @return Adapter
 */
class AdapterFactory extends BjyProfilerProfilingAdapterFactory {

    /**
     * Return new instance of Db Adapter
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        $dbParams = $config['db'];

        if ($config['dinazendDbProfiler']) {
            return new ProfilingAdapter($dbParams);
        } else {
            // @codeCoverageIgnoreStart
            return new Adapter($dbParams);
            // @codeCoverageIgnoreEnd
        }
    }

}
