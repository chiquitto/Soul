<?php

namespace Chiquitto\Soul\Db\Adapter;

use Chiquitto\Soul\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;

/**
 * Description of ProfilingAdapterFactory 
 * 
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br> 
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html
 * @codeCoverageIgnore
 * @return Adapter 
 */
class AdapterWriteFactory extends AdapterFactory
{

    protected function invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');
        $dbParams = $config['dbw'];

        if (isset($dbParams['dbprofiler'])) {
            return new ProfilingAdapterWrite($dbParams);
        } else {
            // @codeCoverageIgnoreStart 
            return new AdapterWrite($dbParams);
            // @codeCoverageIgnoreEnd 
        }
    }

}
