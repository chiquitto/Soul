<?php

namespace Chiquitto\SoulTest\Acl;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\SoulTest\Classes\Acl\Groups;
use Chiquitto\SoulTest\Classes\Acl\Privileges;

class GroupsTest extends TestCase
{
    public function testGetGroups()
    {
        $actual = Groups::getGroups();

        $this->assertArrayHasKey(Groups::GROUP_CLIENT, $actual);
        $this->assertArrayHasKey(Groups::GROUP_PRODUCT, $actual);
        $this->assertArrayHasKey(Groups::GROUP_ORDER, $actual);
        $this->assertArrayHasKey(Groups::GROUP_USER, $actual);
    }

    public function testGetGroupName()
    {
        $this->assertEquals('Client', Groups::getGroupName(Groups::GROUP_CLIENT));
    }

    public function testGetGroupsName()
    {
        $actual = Groups::getGroupsName();

        $this->assertEquals(array(
            Groups::GROUP_CLIENT => 'Client',
            Groups::GROUP_ORDER => 'Order',
            Groups::GROUP_PRODUCT => 'Product',
            Groups::GROUP_USER => 'User',
        ), $actual);
    }

    public function testGetPrivilegesIdByGroupId()
    {
        $actual = Groups::getPrivilegesIdByGroupId(Groups::GROUP_CLIENT);

        $this->assertEquals(array(
            Privileges::CLIENT_CREATE,
        ), $actual);
    }
}
