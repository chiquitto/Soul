<?php

namespace Chiquitto\SoulTest\Util;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Util\Arrays;

class ArraysTest extends TestCase
{
    public function testPrepareParams()
    {
        $params = [
            'name' => 'John Doe',
            'age' => 40,
        ];

        $actual = Arrays::prepareParams($params);

        $this->assertEquals([
            '{name}' => 'John Doe',
            '{age}' => 40,
        ], $actual);
    }

    public function testPrepareParamsEmpty()
    {
        $expected = [];

        $actual = Arrays::prepareParams($expected);

        $this->assertEquals($expected, $actual);
    }
}
