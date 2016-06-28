<?php

namespace Chiquitto\SoulTest\Classes\Acl;

use Chiquitto\Soul\Acl\Resources as SoulResources;

class Resources extends SoulResources
{

    const CLIENT_CREATE = 'ClientModel::createParent';
    const ORDER_CREATE = 'OrderModel::create';
    const ORDER_SET_CLIENT = 'OrderModel::setClient';
    const PRODUCT_ACTIVATE = 'ProductModel::activate';
    const PRODUCT_CREATE = 'ProductModel::create';
    const PRODUCT_SIMPLE_ACTIVATE = 'ProductSimpleModel::activate';
    const PRODUCT_SIMPLE_CREATE = 'ProductSimpleModel::createSimple';
    const PRODUCT_SIMPLE_UPDATE = 'ProductSimpleModel::updateSimple';
    const ROLE_ADD_PRIVILEGES = 'RoleModel::addPrivileges';
    const ROLE_CREATE = 'RoleModel::create';
    const ROLE_UPDATE = 'RoleModel::update';
    const SKU_ACTIVATE = 'SkuModel::activate';
    const SKU_ACTIVATE_BY_PRODUCT = 'SkuModel::activateByIdproduct';
    const USER_ACTIVATE = 'UserModel::activate';
    const USER_CREATE = 'UserModel::create';
    const USER_UPDATE_ACCESS_DATA = 'UserModel::updateAccessData';
    const USER_SUSPEND = 'UserModel::suspend';

    protected static $extendedResources = [
        self::ORDER_SET_CLIENT => self::ORDER_CREATE,
        self::PRODUCT_ACTIVATE => self::PRODUCT_CREATE,
        self::PRODUCT_SIMPLE_ACTIVATE => self::PRODUCT_ACTIVATE,
        self::PRODUCT_SIMPLE_CREATE => self::PRODUCT_CREATE,
        self::PRODUCT_SIMPLE_UPDATE => self::PRODUCT_SIMPLE_CREATE,
        self::ROLE_ADD_PRIVILEGES => self::ROLE_CREATE,
        self::ROLE_UPDATE => self::ROLE_CREATE,
        self::SKU_ACTIVATE => self::PRODUCT_ACTIVATE,
        self::SKU_ACTIVATE_BY_PRODUCT => self::PRODUCT_ACTIVATE,
        self::USER_ACTIVATE => self::USER_CREATE,
        self::USER_UPDATE_ACCESS_DATA => self::USER_CREATE,
        self::USER_SUSPEND => self::USER_CREATE,
    ];
    protected static $resources = [
        self::CLIENT_CREATE => [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::CLIENT_CREATE
                    ]
                ]
            ]
        ],
        self::ORDER_CREATE => [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::ORDER_CREATE
                    ]
                ]
            ]
        ],
        self::PRODUCT_CREATE => [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::PRODUCT_CREATE
                    ]
                ]
            ]
        ],
        self::ROLE_CREATE => [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::USER_ACL
                    ]
                ]
            ]
        ],
        self::USER_CREATE => [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::USER_CREATE
                    ]
                ]
            ]
        ],
    ];

}
