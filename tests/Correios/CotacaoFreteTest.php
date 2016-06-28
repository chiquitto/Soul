<?php

namespace Chiquitto\SoulTest\Correios;

use Chiquitto\Soul\Correios\CotacaoFrete;
use Chiquitto\Soul\Test\TestCase;

class CotacaoFreteTest extends TestCase
{
    public function testCalc()
    {
        $cotacao = new CotacaoFrete();

        $cotacao->addServico(CotacaoFrete::PAC_SEM_CONTRATO);
        $cotacao->addServico(CotacaoFrete::SEDEX_SEM_CONTRATO);

        $cotacao->setCepDestino(58326000);
        $cotacao->setCepOrigem(87200426);

        $cotacao->setPesoKg(1);

        $resultado = $cotacao->calc();
    }
}
