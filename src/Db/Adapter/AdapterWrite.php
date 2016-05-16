<?php

namespace Soul\Db\Adapter;

/**
 * Description of AdapterWrite
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 * @codeCoverageIgnore
 */
class AdapterWrite extends Adapter {

    public function beginTransaction() {
        $this->getDriver()->getConnection()->beginTransaction();
        return true;
    }

    public function commit() {
        $this->getDriver()->getConnection()->commit();
        return true;
    }

    public function rollback() {
        $this->getDriver()->getConnection()->rollback();
        return true;
    }

}
