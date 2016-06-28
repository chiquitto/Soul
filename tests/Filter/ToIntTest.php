<?php

namespace Chiquitto\SoulTest\Filter;

use Chiquitto\Soul\Filter\ToInt;
use Chiquitto\Soul\Test\TestCase;

class ToIntTest extends TestCase
{
    public function testClearProfiles()
    {
        $filter = new ToInt();

        $this->assertEquals(0, $filter->filter('abc'));
        $this->assertEquals(1, $filter->filter('1'));
    }
}