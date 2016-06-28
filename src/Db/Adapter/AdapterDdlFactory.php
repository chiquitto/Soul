<?php

namespace Chiquitto\Soul\Db\Adapter;

use Chiquitto\Soul\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;

/**
 * Description of AdapterDdlFactory
 * 
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br> 
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html
 * @codeCoverageIgnore
 * @return Adapter 
 */
class AdapterDdlFactory extends AdapterFactory
{

    protected function invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');
        $dbParams = $config['dbddl'];

        if (isset($dbParams['dbprofiler'])) {
            return new ProfilingAdapterDdl($dbParams);
        } else {
            // @codeCoverageIgnoreStart
            return new AdapterDdl($dbParams);
            // @codeCoverageIgnoreEnd 
        }
    }

}
