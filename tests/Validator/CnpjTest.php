<?php

namespace Chiquitto\SoulTest\Validator;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Util\CpfCnpj;
use Chiquitto\Soul\Validator\Cnpj;
use Chiquitto\Soul\Validator\Cpf;


class CnpjTest extends TestCase
{
    public function testIsvalid()
    {
        $cnpj = CpfCnpj::gerarCnpj();

        $val = new Cnpj();
        $this->assertTrue($val->isValid($cnpj));
    }

    public function testIsvalidInvalidDigit()
    {
        $cnpj = CpfCnpj::gerarCnpj();

        $d0 = $cnpj[0];
        $d0 = substr(++$d0, 0, 1);

        $cnpj[0] = $d0;

        $val = new Cnpj();
        $this->assertFalse($val->isValid($cnpj));
    }
}
