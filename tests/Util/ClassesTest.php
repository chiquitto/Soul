<?php

namespace Chiquitto\SoulTest\Util;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Util\Classes;

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
