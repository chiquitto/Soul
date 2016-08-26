<?php

namespace Chiquitto\Soul\Db\Adapter;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Description of ProfilingAdapterFactory
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @link https://zf2-docs.readthedocs.org/en/latest/modules/zend.log.writers.html
 * @codeCoverageIgnore
 * @return Adapter
 */
class AdapterFactory implements FactoryInterface
{

    protected $adapterClass = Adapter::class;
    protected $profilingAdapterClass = null;

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');
        if (isset($config['db'][$requestedName])) {
            return $this->invokeDefault($container, $requestedName, $options);
        }

        return $this->invoke($container, 'default', $options);
    }

    protected function invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');

        if (isset($config['db'][$requestedName]['dbprofiler'])) {
            return new $this->profilingAdapterClass($config['db'][$requestedName]);
        } else {
            // @codeCoverageIgnoreStart
            return new $this->adapterClass($config['db'][$requestedName]);
            // @codeCoverageIgnoreEnd
        }
    }

    protected function invokeDefault(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->invoke($container, 'default', $options);
    }

}
