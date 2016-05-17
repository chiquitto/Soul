<?php

namespace Chiquitto\Soul\Db\Adapter;

use Zend\Db\Adapter\AdapterInterface as ZendAdapterInterface;

/**
 *
 * @author chiquitto
 */
interface AdapterInterface extends ZendAdapterInterface {
    public function beginTransaction();

    public function commit();

    public function rollback();
}
