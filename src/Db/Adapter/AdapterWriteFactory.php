<?php

namespace Chiquitto\Soul\Db\Adapter;

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

    protected $adapterClass = AdapterWrite::class;
    protected $profilingAdapterClass = ProfilingAdapterWrite::class;

}
