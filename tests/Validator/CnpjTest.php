<?php

namespace Chiquitto\SoulTest\Validator;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Validator\Cnpj;

class CnpjTest extends TestCase
{
    public function testIsvalid()
    {
        $cnpj = \Chiquitto\Soul\Util\Cnpj::generate();

        $val = new Cnpj();
        $this->assertTrue($val->isValid($cnpj));
    }

    public function testIsvalidInvalidDigit()
    {
        $cnpj = \Chiquitto\Soul\Util\Cnpj::generate();

        $d0 = $cnpj[0];
        $d0 = substr(++$d0, 0, 1);

        $cnpj[0] = $d0;

        $val = new Cnpj();
        $this->assertFalse($val->isValid($cnpj));
    }
}
