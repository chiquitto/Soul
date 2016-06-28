<?php

namespace Chiquitto\SoulTest\Acl;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\SoulTest\Classes\Acl\Privileges;

class PrivilegesTest extends TestCase
{
    public function testGetPrivilegesId()
    {
        $actual = Privileges::getPrivilegesId();

        $this->assertEquals(array(
            Privileges::CLIENT_CREATE,
            Privileges::ORDER_CREATE,
            Privileges::PRODUCT_VIEW,
            Privileges::PRODUCT_CREATE,
            Privileges::PRODUCT_ENABLE,
            Privileges::USER_VIEW,
            Privileges::USER_CREATE,
            Privileges::USER_ENABLE,
            Privileges::USER_ACL,
        ), $actual);
    }

    public function testGetPrivilegesName()
    {
        $actual = Privileges::getPrivilegesName();

        $this->assertEquals(array(
            Privileges::CLIENT_CREATE => 'New Client',
            Privileges::ORDER_CREATE => 'New Order',
            Privileges::PRODUCT_VIEW => 'Product View',
            Privileges::PRODUCT_CREATE => 'New Product',
            Privileges::PRODUCT_ENABLE => 'Product Status',
            Privileges::USER_VIEW => 'View User',
            Privileges::USER_CREATE => 'New User',
            Privileges::USER_ENABLE => 'User Status',
            Privileges::USER_ACL => 'ACL',
        ), $actual);
    }

}
