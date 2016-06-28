<?php

namespace DinaZendTest\Model;

use ArrayIterator;
use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Underscore\Arrays;


/**
 * Description of ArraysTest
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class ArraysTest extends TestCase {

    public function testEachIterator() {
        $iterator1 = new ArrayIterator([1, 2, 3, 4, 5, 6]);
        $iterator2 = clone $iterator1;

        $expected = array();
        foreach ($iterator2 as $value) {
            $expected[] = $value * 2;
        }

        $actual = Arrays::eachIterator($iterator1, function($v) {
                    return $v * 2;
                });

        $this->assertEquals($expected, $actual);
    }

}
