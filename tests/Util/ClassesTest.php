<?php

namespace SoulTest\Util;

use Soul\Test\TestCase;
use Soul\Util\Classes;

/**
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class ClassesTest extends TestCase
{

    public function testShortName()
    {
        $classNameExploded = explode('\\', self::class);
        $expected = array_pop($classNameExploded);

        $this->assertEquals($expected, Classes::shortName(self::class));
    }
    
    public function testShortName2()
    {
        $classNameExploded = explode('\\', self::class);
        $expected = array_pop($classNameExploded);

        $this->assertEquals($expected, Classes::shortName($expected));
    }

}
