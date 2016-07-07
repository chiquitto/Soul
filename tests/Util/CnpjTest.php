<?php

namespace Chiquitto\SoulTest\Util;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Validator\Cnpj;
use Chiquitto\Soul\Validator\Cpf;

class CnpjTest extends TestCase
{
    public function testGenerate()
    {
        $val = new Cnpj();
        for ($i = 0; $i < 1000; $i++) {
            $cnpj = \Chiquitto\Soul\Util\Cnpj::generate();

            $this->assertTrue($val->isValid($cnpj), "$cnpj invalido");
            $this->assertTrue(\Chiquitto\Soul\Util\Cnpj::isValid($cnpj), "$cnpj invalido");
        }
    }
}
