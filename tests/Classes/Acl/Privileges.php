<?php

namespace Chiquitto\SoulTest\Classes\Acl;

use Chiquitto\Soul\Acl\Privileges as SoulPrivileges;

class Privileges extends SoulPrivileges
{

    const USER_VIEW = 1001;
    const USER_CREATE = 1002;
    const USER_ENABLE = 1003;
    const USER_ACL = 1004;
    const PRODUCT_VIEW = 2001;
    const PRODUCT_CREATE = 2002;
    const PRODUCT_ENABLE = 2003;
    const CLIENT_CREATE = 3001;
    const ORDER_CREATE = 4001;

    protected static $privilegesName = array(
        self::CLIENT_CREATE => 'New Client',
        self::ORDER_CREATE => 'New Order',
        self::PRODUCT_VIEW => 'Product View',
        self::PRODUCT_CREATE => 'New Product',
        self::PRODUCT_ENABLE => 'Product Status',
        self::USER_VIEW => 'View User',
        self::USER_CREATE => 'New User',
        self::USER_ENABLE => 'User Status',
        self::USER_ACL => 'ACL',
    );

}
