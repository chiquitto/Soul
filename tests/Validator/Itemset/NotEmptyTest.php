<?php

namespace Chiquitto\SoulTest\Validator\Itemset;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Validator\Itemset\NotEmpty;
use Chiquitto\SoulTest\Classes\Model\Vo\Carro;
use Chiquitto\SoulTest\Classes\Model\Vo\Carroset;


/**
 * Description of NotEmptyTest
 *
 * @author chiquitto
 */
class NotEmptyTest extends TestCase
{
    public function testEmptyItemset()
    {
        $carroset = new Carroset();
        $validator = new NotEmpty();

        var_dump($validator->isValid($carroset));
        $this->assertFalse($validator->isValid($carroset));
    }

    public function testNotemptyItemset()
    {
        $carroset = new Carroset();
        $carroset->add(new Carro());

        $validator = new NotEmpty();
        
        $this->assertTrue($validator->isValid($carroset));
    }
}
