<?php

namespace Chiquitto\Soul\Db\Adapter;

use BjyProfiler\Db\Adapter\ProfilingAdapter as BjyProfilerProfilingAdapter;
use Chiquitto\Soul\Db\Profiler\BjyProfilerProfiler;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Adapter\Profiler\ProfilerInterface;
use Zend\Db\ResultSet\ResultSetInterface;

/**
 * Description of AdapterWrite
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @codeCoverageIgnore
 */
class ProfilingAdapterWrite extends BjyProfilerProfilingAdapter implements AdapterInterface
{

    public function __construct($driver, PlatformInterface $platform = null, ResultSetInterface $queryResultPrototype = null, ProfilerInterface $profiler = null)
    {
        parent::__construct($driver, $platform, $queryResultPrototype, $profiler);

        $this->setProfiler(new BjyProfilerProfiler());
        $this->injectProfilingStatementPrototype();
    }

    public function beginTransaction()
    {
        $this->getProfiler()->startQuery("BEGIN");
        $this->getDriver()->getConnection()->beginTransaction();
        $this->getProfiler()->endQuery();
        return true;
    }

    public function commit()
    {
        $this->getProfiler()->startQuery("COMMIT");
        $this->getDriver()->getConnection()->commit();
        $this->getProfiler()->endQuery();
        return true;
    }
    
    public function rollback()
    {
        $this->getProfiler()->startQuery("ROLLBACK");
        $this->getDriver()->getConnection()->rollback();
        $this->getProfiler()->endQuery();
        return true;
    }

}
