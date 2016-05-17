<?php

namespace Chiquitto\Soul\Db\Adapter;

use Interop\Container\ContainerInterface;
use Chiquitto\Soul\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Description of AdapterDdlFactory
 * 
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br> 
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html 
 * @return Adapter 
 */
class AdapterDdlFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');
        $dbParams = $config['dbddl'];

        if (isset($config['dinazendDbProfiler'])) {
            return new ProfilingAdapter($dbParams);
        } else {
            // @codeCoverageIgnoreStart 
            return new Adapter($dbParams);
            // @codeCoverageIgnoreEnd 
        }
    }

}
