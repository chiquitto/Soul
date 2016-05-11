<?php

namespace SoulTest\Util;

use Soul\Test\TestCase;
use Soul\Util\String;

/**
 * Description of String
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class StringTest extends TestCase {
    public function testRandomString() {
        $actual = String::randomString();
        $this->assertEquals(10, strlen($actual));
        
        $actual = String::randomString(5);
        $this->assertEquals(5, strlen($actual));
        
        $actual = String::randomString(5, 'a');
        $this->assertEquals(5, strlen($actual));
        $this->assertEquals('aaaaa', $actual);
    }
    
    public function testRemoveAcentos()
    {
        $arrayTest = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $arrayExpected = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        
        foreach ($arrayTest as $k => $v) {
            $this->assertEquals($arrayExpected[$k], String::removeAcentos($v));
        }
    }
    
    public function testStrToPermalink()
    {
        $arrayTest = [
            'Sobretudo Juvenil Fechamento de Botão Preto',
            'Vestido Abertura nas Costas Juvenil Preto',
            'Vestido com Alças Estampado Juvenil',
            'Vestido Curto Estampa de Poá e Azul',
            'Conjunto Juvenil Branco Estampado e Rosa',
            'Conjunto Juvenil (Preto e Branco)'
        ];
        $arrayExpected = [
            'sobretudo-juvenil-fechamento-de-botao-preto',
            'vestido-abertura-nas-costas-juvenil-preto',
            'vestido-com-alcas-estampado-juvenil',
            'vestido-curto-estampa-de-poa-e-azul',
            'conjunto-juvenil-branco-estampado-e-rosa',
            'conjunto-juvenil-preto-e-branco'
        ];
        
        foreach ($arrayTest as $k => $v) {
            $this->assertEquals($arrayExpected[$k], String::strToPermalink($v));
        }
    }
}
