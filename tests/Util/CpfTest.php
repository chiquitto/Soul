<?php

namespace Chiquitto\SoulTest\Util;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Validator\Cpf;

class CpfTest extends TestCase
{
    public function testGenerate()
    {
        $val = new Cpf();
        for ($i = 0; $i < 1000; $i++) {
            $cpf = \Chiquitto\Soul\Util\Cpf::generate();

            $this->assertTrue($val->isValid($cpf), "$cpf invalido");
            $this->assertTrue(\Chiquitto\Soul\Util\Cpf::isValid($cpf), "$cpf invalido");
        }
    }
}
