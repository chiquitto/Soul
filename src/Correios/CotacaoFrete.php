<?php
/**
 * Created by PhpStorm.
 * User: chiquitto
 * Date: 24/06/16
 * Time: 10:54
 */

namespace Chiquitto\Soul\Correios;


class CotacaoFrete
{
    const E_SEDEX_COM_CONTRATO = 81019;
    const E_SEDEX_EXPRESS_COM_CONTRATO = 81035;
    const E_SEDEX_PRIORITARIO_COM_CONTRATO = 81027;
    const PAC_COM_CONTRATO = 41068;
    const PAC_SEM_CONTRATO = 41106;
    const SEDEX_10_SEM_CONTRATO = 40215;
    const SEDEX_A_COBRAR_SEM_CONTRATO = 40045;
    const SEDEX_A_COBRAR_COM_CONTRATO = 40126;
    const SEDEX_COM_CONTRATO = 40096;
    //const SEDEX_COM_CONTRATO = 40436;
    //const SEDEX_COM_CONTRATO = 40444;
    //const SEDEX_COM_CONTRATO = 40568;
    //const SEDEX_COM_CONTRATO = 40606;
    const SEDEX_HOJE_SEM_CONTRATO = 40290;
    const SEDEX_SEM_CONTRATO = 40010;
    const URL_WS = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';
    const MAX_PESO = 30;
    const MAX_VOLUME = 280000;
    const MIN_ALTURA = 2;
    const MIN_LARGURA = 11;
    const MIN_COMPRIMENTO = 16;
    const FORA_INTERVALO_DESATIVADO = '1';

    /**
     * Com base no site dos correios calcula em um pacote
     *  com medidas e peso maximo fornecidos pelos correios
     */
    const FORA_DO_INTERVALO_MAX_UNICO = '2';

    /**
     * Com base no site dos correios calcula quantidade de
     *  pacotes necessarias e cada pacote com medidas
     * e peso maximos fornecidos pelos correios
     */
    const FORA_DO_INTERVALO_MAX_PACOTES = '3';

    /**
     * Com base no site dos correios calcula quantidade de pacotes necessarios
     * com medida e peso com base na media dos volumes
     */
    const FORA_DO_INTERVALO_MEDIA = '4';

    /**
     * Codigo administrativo junto a ECT
     *
     * @var string
     */
    private $nCdEmpresa = '';

    /**
     * Senha para acesso ao servico
     *
     * @var string
     */
    private $sDsSenha = '';

    /**
     * Codigo do servico
     *
     * @var array
     */
    private $nCdServico = array();

    /**
     * CEP de origem sem hifen
     *
     * @var string
     */
    private $sCepOrigem;

    /**
     * CEP de destino sem hifen
     *
     * @var string
     */
    private $sCepDestino;

    /**
     * Peso da encomenda em kg, incluindo sua embalagem
     *
     * @var real
     */
    private $nVlPeso = 0;

    /**
     * Formato da encomenda.
     * 1=Caixa/Pacote;
     * 2=Prisma/Rolo;
     *
     * @var int
     */
    private $nCdFormato = 1;

    /**
     * Comprimento da encomenda em centimetros
     *
     * @var int
     */
    private $nVlComprimento = self::MIN_COMPRIMENTO;

    /**
     * Altura da encomenda em centimetros
     *
     * @var int
     */
    private $nVlAltura = self::MIN_COMPRIMENTO;

    /**
     * Largura da encomenda em centimetros
     *
     * @var int
     */
    private $nVlLargura = self::MIN_COMPRIMENTO;

    /**
     * Diametro da encomenda em centimetros
     *
     * @var int
     */
    private $nVlDiametro = 0;
    private $nVlAcaoForaIntervalo = 0;

    /**
     * Indica se a encomenda sera entregue com o servico adicional mao propria
     *
     * @var boolean
     */
    private $sCdMaoPropria = 'N';

    /**
     * Indica se a encomenda sera entregue com o servico adicional valor declarado.
     * Neste campo deve ser apresentado o valor declarado desejado, em R$.
     *
     * @var real
     */
    private $nVlValorDeclarado = 0;

    /**
     * Volume em cm3
     *
     * @var int
     */
    private $nVolume = 0;
    private $qtPacotes = 1;

    /**
     * Indica se a encomenda sera entregue com o serviço adicional aviso de recebimento.
     * S = Sim;
     * N = Nao
     *
     * @var type
     */
    private $sCdAvisoRecebimento = 'N';
    public static $servicos = array(
        self::E_SEDEX_COM_CONTRATO => 'e-SEDEX, com contrato',
        self::E_SEDEX_EXPRESS_COM_CONTRATO => 'e-SEDEX Express, com contrato',
        self::E_SEDEX_PRIORITARIO_COM_CONTRATO => 'e-SEDEX Prioritário, com contrato',
        self::PAC_COM_CONTRATO => 'PAC com contrato',
        self::PAC_SEM_CONTRATO => 'PAC sem contrato',
        self::SEDEX_10_SEM_CONTRATO => 'SEDEX 10, sem contrato',
        self::SEDEX_A_COBRAR_SEM_CONTRATO => 'SEDEX a Cobrar, sem contrato',
        self::SEDEX_A_COBRAR_COM_CONTRATO => 'SEDEX a Cobrar, com contrato',
        self::SEDEX_COM_CONTRATO => 'SEDEX com contrato',
        self::SEDEX_HOJE_SEM_CONTRATO => 'SEDEX Hoje, sem contrato',
        self::SEDEX_SEM_CONTRATO => 'SEDEX sem contrato',
    );
    public static $servicosUser = array(
        self::E_SEDEX_COM_CONTRATO => 'Entrega expressa',
        self::E_SEDEX_EXPRESS_COM_CONTRATO => 'Entrega expressa',
        self::E_SEDEX_PRIORITARIO_COM_CONTRATO => 'Entrega expressa',
        self::PAC_COM_CONTRATO => 'Encomenda normal',
        self::PAC_SEM_CONTRATO => 'Encomenda normal',
        self::SEDEX_10_SEM_CONTRATO => 'Entrega expressa',
        self::SEDEX_A_COBRAR_SEM_CONTRATO => 'SEDEX a cobrar',
        self::SEDEX_A_COBRAR_COM_CONTRATO => 'SEDEX a cobrar',
        self::SEDEX_COM_CONTRATO => 'Entrega expressa',
        self::SEDEX_HOJE_SEM_CONTRATO => 'SEDEX Hoje, sem contrato',
        self::SEDEX_SEM_CONTRATO => 'Entrega expressa',
    );

    /**
     * Adiciona um servico ao calculo do frete
     *
     * @param int $servico
     */
    public function addServico($servico)
    {
        $this->nCdServico[] = $servico;
    }

    /**
     * Faz o calculo do frete
     *
     * @param string $returnFormat O tipo do retorno.
     * Pode ser JSON ou Objeto.
     * O padrao eh Objeto.
     *
     * @return array|json
     */
    public function calc($returnFormat = 'object')
    {
        $parms = new \stdClass();
        $cm = '';

        if (($this->nVlPeso > self::MAX_PESO) or ( $this->getVolume() > self::MAX_VOLUME)) {
            $this->foraDoIntervalo();
            //$cm = ceil(pow($config['volumeItens'], 1 / 3));
        }

        $parms->nCdServico = join(',', $this->nCdServico);
        $parms->nCdEmpresa = $this->nCdEmpresa;
        $parms->sDsSenha = $this->sDsSenha;
        $parms->StrRetorno = 'XML';

        $parms->sCepDestino = $this->sCepDestino;
        $parms->sCepOrigem = $this->sCepOrigem;
        $parms->nVlPeso = $this->nVlPeso;

        $parms->nVlComprimento = $this->nVlComprimento;
        $parms->nVlDiametro = $this->nVlDiametro;
        $parms->nVlAltura = $this->nVlAltura;
        $parms->nVlLargura = $this->nVlLargura;

        $parms->nCdFormato = $this->nCdFormato;
        $parms->sCdMaoPropria = $this->sCdMaoPropria ? 'S' : 'N';
        $parms->nVlValorDeclarado = $this->nVlValorDeclarado;
        $parms->sCdAvisoRecebimento = $this->sCdAvisoRecebimento ? 'S' : 'N';

        //try {
        $soap = new \SoapClient(self::URL_WS, array(
            'trace' => true,
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_DISK,
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
            'connection_timeout' => 1000,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
        ));

        $resposta = $soap->CalcPrecoPrazo($parms);
        unset($soap);
        //} catch (Exception $e) {
        //	die('ERRO PARA CALCULAR');
        //	return false;
        //}
        $objeto = $resposta->CalcPrecoPrazoResult->Servicos->cServico;

        foreach ($objeto as & $item) {
            $item->Valor = ((int) strtr($item->Valor, array(',' => ''))) * ceil($this->qtPacotes);
            $item->ValorSemAdicionais = ((int) strtr($item->ValorSemAdicionais, array(',' => ''))) * ceil($this->qtPacotes);
            $item->ValorMaoPropria = ((int) strtr($item->ValorMaoPropria, array(',' => ''))) * ceil($this->qtPacotes);
            $item->ValorAvisoRecebimento = ((int) strtr($item->ValorAvisoRecebimento, array(',' => ''))) * ceil($this->qtPacotes);
            $item->ValorValorDeclarado = ((int) strtr($item->ValorValorDeclarado, array(',' => ''))) * ceil($this->qtPacotes);
        }

        switch ($returnFormat) {
            case 'json':
                return json_encode($objeto);
                break;
            default:
                return $objeto;
                break;
        }
    }

    public function getServicoNome($cdServico)
    {
        return self::$servicos[$cdServico];
    }

    /**
     * Retorna o volume em cm3
     *
     * @return int
     */
    private function getVolume()
    {
        return $this->nVolume;
    }

    public function setAcaoForaIntervalo($acao)
    {
        $this->nVlAcaoForaIntervalo = $acao;
    }

    /**
     * Informa a altura (Deve ser informado em Centimetros)
     *
     * @param int
     */
    public function setAlturaCm($altura)
    {
        $this->nVlAltura = (int) $altura;

        $this->nVolume = $this->nVlAltura * $this->nVlComprimento * $this->nVlLargura;
    }

    /**
     * Informa se o calculo será feito com aviso de recebimento
     *
     * @param boolean
     */
    public function setAvisoRecebimento($avisorecebimento)
    {
        if (is_bool($avisorecebimento)) {
            $this->sCdAvisoRecebimento = $avisorecebimento;
        } else {
            $this->sCdAvisoRecebimento = (($avisorecebimento === 'S') or ( $avisorecebimento == '1'));
        }
    }

    public function setCdEmpresa($cdEmpresa)
    {
        $this->nCdEmpresa = $cdEmpresa;
    }

    public function setCepDestino($cep)
    {
        $this->sCepDestino = preg_replace('#([^0-9])#i', '', $cep);
    }

    public function setCepOrigem($cep)
    {
        $this->sCepOrigem = preg_replace('#([^0-9])#i', '', $cep);
    }

    /**
     * Informa o comprimento (Deve ser informado em Centimetros)
     *
     * @param int
     */
    public function setComprimentoCm($comprimento)
    {
        $this->nVlComprimento = (int) $comprimento;

        $this->nVolume = $this->nVlAltura * $this->nVlComprimento * $this->nVlLargura;
    }

    /**
     * Informa o diametro (Deve ser informado em Centimetros)
     *
     * @param int
     */
    public function setDiametroCm($diametro)
    {
        $this->nVlDiametro = (int) $diametro;
    }

    public function setDsSenha($dsSenha)
    {
        $this->sDsSenha = $dsSenha;
    }

    /**
     * Informa a largura (Deve ser informado em Centimetros)
     *
     * @param int
     */
    public function setLarguraCm($largura)
    {
        $this->nVlLargura = (int) $largura;

        $this->nVolume = $this->nVlAltura * $this->nVlComprimento * $this->nVlLargura;
    }

    /**
     * Informa se deve calcular com o servico mão própria
     *
     * @param boolean
     */
    public function setMaoPropria($maopropria)
    {
        if (is_bool($maopropria)) {
            $this->sCdMaoPropria = $maopropria;
        } else {
            $this->sCdMaoPropria = (($maopropria === 'S') or ( $maopropria == '1'));
        }
    }

    public function setPesoKg($peso)
    {
        $this->nVlPeso = $peso;
    }

    /**
     * Informa o peso em gramas
     *
     * @param int
     */
    public function setPesoG($peso)
    {
        $this->setPesoKg($peso / 1000);
    }

    /**
     * Altera os servicos
     *
     * @param int $servico
     */
    public function setServico(array $servico)
    {
        $this->nCdServico = $servico;
    }

    /**
     * Informa o valor declarado em centavos
     *
     * @param int
     */
    public function setValorDeclaradoC($valordeclarado)
    {
        $this->setValorDeclaradoR($valordeclarado / 100);
    }

    /**
     * Informa o valor declarado em reais
     *
     * @param real
     */
    public function setValorDeclaradoR($valordeclarado)
    {
        $this->nVlValorDeclarado = $valordeclarado;
    }

    /**
     * Define o volume do pacote.
     * Ao utilizar este metodo, a altura, largura e comprimento serao redefinidos
     *
     * @param int $volume
     */
    public function setVolume($volume)
    {
        $this->nVolume = $volume;

        $cm = ceil(pow($volume, 1 / 3));
        $this->nVlAltura = $cm;
        $this->nVlLargura = $cm;
        $this->nVlComprimento = $cm;
    }

    public function calculaValoresMaximos()
    {
        $this->qtPacotes = 1;
        $this->setVolume(self::MAX_VOLUME);
        $this->setPesoKg(self::MAX_PESO);
    }

    public function calculaMaximoPacotes()
    {
        $pVolume = $this->getVolume() / self::MAX_VOLUME;
        $pPeso = $this->nVlPeso / self::MAX_PESO;

        $this->qtPacotes = max($pVolume, $pPeso);

        $this->setVolume(self::MAX_VOLUME);
        $this->setPesoKg(self::MAX_PESO);
    }

    public function calculaMedia()
    {
        $pVolume = $this->getVolume() / self::MAX_VOLUME;
        $pPeso = $this->nVlPeso / self::MAX_PESO;

        $this->qtPacotes = max($pVolume, $pPeso);
        $this->nVolume = $this->nVolume / ceil($this->qtPacotes);
        $this->nVlPeso = $this->nVlPeso / ceil($this->qtPacotes);
    }

    public function foraDoIntervalo()
    {
        switch ($this->nVlAcaoForaIntervalo) {
            case self::FORA_INTERVALO_DESATIVADO;
                return;
                break;
            case self::FORA_DO_INTERVALO_MAX_UNICO:
                $this->calculaMaximo();
                break;
            case self::FORA_DO_INTERVALO_MAX_PACOTES:
                $this->calculaMaximoPacotes();
                break;
            case self::FORA_DO_INTERVALO_MEDIA:
                $this->calculaMedia();
                break;
        }
    }
}