<?php

namespace Chiquitto\SoulTest\Classes\Acl;

use Chiquitto\Soul\Acl\Groups as SoulGroups;

class Groups extends SoulGroups
{

    const GROUP_USER = 1;
    const GROUP_PRODUCT = 2;
    const GROUP_CLIENT = 3;
    const GROUP_ORDER = 4;

    protected static $groupName = array(
        self::GROUP_CLIENT => 'Client',
        self::GROUP_ORDER => 'Order',
        self::GROUP_PRODUCT => 'Product',
        self::GROUP_USER => 'User',
    );
    protected static $groups = array(
        self::GROUP_CLIENT => array(
            Privileges::CLIENT_CREATE,
        ),
        self::GROUP_ORDER => array(
            Privileges::ORDER_CREATE,
        ),
        self::GROUP_PRODUCT => array(
            Privileges::PRODUCT_VIEW,
            Privileges::PRODUCT_CREATE,
            Privileges::PRODUCT_ENABLE,
        ),
        self::GROUP_USER => array(
            Privileges::USER_VIEW,
            Privileges::USER_CREATE,
            Privileges::USER_ENABLE,
            Privileges::USER_ACL,
        ),
    );

}
