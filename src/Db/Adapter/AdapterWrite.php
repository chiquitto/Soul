<?php

namespace Soul\Db\Adapter;

/**
 * Description of ProfilingAdapter
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @codeCoverageIgnore
 */
class AdapterWrite extends Adapter implements AdapterInterface {

    public function beginTransaction() {
        //$this->getProfiler()->startQuery("BEGIN TRANSACTION");
        $this->getDriver()->getConnection()->beginTransaction();
        //$this->getProfiler()->endQuery();
        return true;
    }

    public function commit() {
        //$this->getProfiler()->startQuery("COMMIT");
        $this->getDriver()->getConnection()->commit();
        //$this->getProfiler()->endQuery();
        return true;
    }

    public function rollback() {
        //$this->getProfiler()->startQuery("ROLLBACK");
        $this->getDriver()->getConnection()->rollback();
        //$this->getProfiler()->endQuery();
        return true;
    }

}
