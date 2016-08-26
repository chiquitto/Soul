<?php

namespace Chiquitto\Soul\Db\Adapter;

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

    protected $adapterClass = AdapterDdl::class;
    protected $profilingAdapterClass = null;

}
