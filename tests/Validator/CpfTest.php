<?php

namespace Chiquitto\SoulTest\Validator;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\Soul\Util\CpfCnpj;
use Chiquitto\Soul\Validator\AbstractCpfCnpj;
use Chiquitto\Soul\Validator\Cpf;


class CpfTest extends TestCase
{
    public function testIsvalid()
    {
        $cpf = CpfCnpj::gerarCpf();

        $val = new Cpf();
        $this->assertTrue($val->isValid($cpf), "$cpf invalido");
    }

    public function testIsvalidInvalid()
    {
        $cpf = CpfCnpj::gerarCpf();

        $d0 = $cpf[0];
        $d0 = substr(++$d0, 0, 1);

        $cpf[0] = $d0;

        $val = new Cpf();
        $this->assertFalse($val->isValid($cpf));
        
        $this->assertArrayHasKey(AbstractCpfCnpj::DIGIT, $val->getMessages());
    }

    public function testIsvalidInvalidSize()
    {
        $cpf = CpfCnpj::gerarCpf() . '0';

        $val = new Cpf();
        $this->assertFalse($val->isValid($cpf));

        $this->assertArrayHasKey(AbstractCpfCnpj::SIZE, $val->getMessages());
    }

    public function testIsvalidInvalidExpanded()
    {
        $cpf = '11111111111';

        $val = new Cpf();
        $this->assertFalse($val->isValid($cpf));

        $this->assertArrayHasKey(AbstractCpfCnpj::EXPANDED, $val->getMessages());
    }
}
