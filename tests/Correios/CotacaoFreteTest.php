<?php

namespace Chiquitto\SoulTest\Correios;

use Chiquitto\Soul\Correios\CotacaoFrete;
use Chiquitto\Soul\Test\TestCase;

class CotacaoFreteTest extends TestCase
{
    public function testCalc()
    {
        $prods = [
            CotacaoFrete::PAC_SEM_CONTRATO,
            CotacaoFrete::SEDEX_SEM_CONTRATO
        ];

        $cotacao = new CotacaoFrete();

        $cotacao->setServico([]);
        foreach ($prods as $prod) {
            $cotacao->addServico($prod);
        }

        $cotacao->setCepDestino(58326000);
        $cotacao->setCepOrigem(87200426);

        $cotacao->setPesoKg(1);
        $cotacao->setPesoG(1000);

        $cotacao->setAlturaCm(20);
        $cotacao->setLarguraCm(20);
        $cotacao->setComprimentoCm(20);
        $cotacao->setDiametroCm(10);

        $cotacao->setAvisoRecebimento(true);
        $cotacao->setMaoPropria(true);

        $cotacao->setValorDeclaradoC(1000);
        $cotacao->setValorDeclaradoR(10);

        $cotacao->setCdEmpresa('');
        $cotacao->setDsSenha('');

        $cotacao->setAcaoForaIntervalo(CotacaoFrete::FORA_INTERVALO_DESATIVADO);

        $resultado = $cotacao->calc();

        $this->assertCount(count($prods), $resultado);

        foreach ($resultado as $prod) {
            $this->assertObjectHasAttribute('Codigo', $prod);
            $this->assertContains($prod->Codigo, $prods);
        }
    }

    public function testCalcForaIntervaloMaxPacotes()
    {
        $prods = [
            CotacaoFrete::PAC_SEM_CONTRATO,
            CotacaoFrete::SEDEX_SEM_CONTRATO
        ];

        $cotacao = new CotacaoFrete();

        foreach ($prods as $prod) {
            $cotacao->addServico($prod);
        }

        $cotacao->setCepDestino(58326000);
        $cotacao->setCepOrigem(87200426);

        $cotacao->setPesoKg(80);

        $cotacao->setAlturaCm(200);
        $cotacao->setLarguraCm(200);
        $cotacao->setComprimentoCm(200);

        $cotacao->setAcaoForaIntervalo(CotacaoFrete::FORA_INTERVALO_MAX_PACOTES);

        $resultado = $cotacao->calc();

        $this->assertCount(count($prods), $resultado);

        foreach ($resultado as $prod) {
            $this->assertObjectHasAttribute('Codigo', $prod);
            $this->assertContains($prod->Codigo, $prods);
        }
    }

    public function testCalcForaIntervaloMaxUnico()
    {
        $prods = [
            CotacaoFrete::PAC_SEM_CONTRATO,
            CotacaoFrete::SEDEX_SEM_CONTRATO
        ];

        $cotacao = new CotacaoFrete();

        foreach ($prods as $prod) {
            $cotacao->addServico($prod);
        }

        $cotacao->setCepDestino(58326000);
        $cotacao->setCepOrigem(87200426);

        $cotacao->setPesoKg(80);

        $cotacao->setAlturaCm(200);
        $cotacao->setLarguraCm(200);
        $cotacao->setComprimentoCm(200);

        $cotacao->setAcaoForaIntervalo(CotacaoFrete::FORA_INTERVALO_MAX_UNICO);

        $resultado = $cotacao->calc();

        $this->assertCount(count($prods), $resultado);

        foreach ($resultado as $prod) {
            $this->assertObjectHasAttribute('Codigo', $prod);
            $this->assertContains($prod->Codigo, $prods);
        }
    }



    public function testCalcForaIntervaloMedia()
    {
        $prods = [
            CotacaoFrete::PAC_SEM_CONTRATO,
            CotacaoFrete::SEDEX_SEM_CONTRATO
        ];

        $cotacao = new CotacaoFrete();

        foreach ($prods as $prod) {
            $cotacao->addServico($prod);
        }

        $cotacao->setCepDestino(58326000);
        $cotacao->setCepOrigem(87200426);

        $cotacao->setPesoKg(80);

        $cotacao->setAlturaCm(200);
        $cotacao->setLarguraCm(200);
        $cotacao->setComprimentoCm(200);

        $cotacao->setAcaoForaIntervalo(CotacaoFrete::FORA_INTERVALO_MEDIA);

        $resultado = $cotacao->calc();

        $this->assertCount(count($prods), $resultado);

        foreach ($resultado as $prod) {
            $this->assertObjectHasAttribute('Codigo', $prod);
            $this->assertContains($prod->Codigo, $prods);
        }
    }

    public function testGetServicoNome()
    {
        $cotacao = new CotacaoFrete();

        $this->assertEquals($cotacao->getServicoNome(CotacaoFrete::PAC_SEM_CONTRATO), CotacaoFrete::$servicos[CotacaoFrete::PAC_SEM_CONTRATO]);
    }
}
