<?php

namespace Chiquitto\SoulTest\Acl;

use Chiquitto\Soul\Acl\Exception\UndefinedResourceException;
use Chiquitto\Soul\Test\TestCase;
use Chiquitto\SoulTest\Classes\Acl\Privileges;
use Chiquitto\SoulTest\Classes\Acl\Resources;

class ResourcesTest extends TestCase
{
    public function testGetResource()
    {
        $expected = [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::ORDER_CREATE
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, Resources::getResource(Resources::ORDER_CREATE));
        $this->assertEquals($expected, Resources::getResource(Resources::ORDER_SET_CLIENT));
    }

    public function testGetResourceUndefinedResource()
    {
        $this->expectException(UndefinedResourceException::class);
        $resource = Resources::getResource('UNDEFINED_RESOURCE');
    }

    public function testGetResourceRules()
    {
        $expected = [
            'rules' => [
                [
                    'type' => 'USER',
                    'privileges' => [
                        Privileges::ORDER_CREATE
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected['rules'], Resources::getResourceRules(Resources::ORDER_CREATE));
        $this->assertEquals($expected['rules'], Resources::getResourceRules(Resources::ORDER_SET_CLIENT));
    }


}
