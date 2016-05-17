<?php

namespace Chiquitto\SoulTest\Exception;

use Chiquitto\Soul\Exception\Exception;
use Chiquitto\Soul\Exception\InvalidArgumentException;
use Chiquitto\Soul\Exception\InvalidDataUserException;
use Chiquitto\Soul\Exception\InvalidInputException;
use Chiquitto\Soul\Exception\InvalidInputsetException;
use Chiquitto\Soul\Exception\InvalidReturnDataTypeException;
use Chiquitto\Soul\Test\TestCase;

class ExceptionTest extends TestCase {

    public function testInvalidArgumentException() {
        $exc = new InvalidArgumentException();
        $this->setExpectedException(InvalidArgumentException::class, '', Exception::INVALID_ARGUMENT);
        throw $exc;
    }
    
    public function testInvalidDataUserException() {
        $exc = new InvalidDataUserException();
        $this->setExpectedException(InvalidDataUserException::class, '', Exception::INVALID_DATA_USER);
        throw $exc;
    }
    
    public function testInvalidInputException() {
        $exc = new InvalidInputException();
        $this->setExpectedException(InvalidInputException::class, '', Exception::INVALID_INPUT_VALIDATOR);
        throw $exc;
    }
    
    public function testInvalidInputExceptionMessages() {
        $expected = array(
            'nome' => array(
                'isEmpty' => 'Valor vazio',
            ),
            'email' => array(
                'isEmpty' => 'Valor vazio',
            ),
        );
        
        $exc = new InvalidInputException();
        $exc->setValidatorMessages($expected);
        
        $this->assertEquals($expected, $exc->getValidatorMessages());
    }
    
    public function testInvalidInputsetException() {
        $exc = new InvalidInputsetException();
        $this->setExpectedException(InvalidInputsetException::class, '', Exception::INVALID_INPUT_VALIDATOR_SET);
        throw $exc;
    }
    
        public function testInvalidInputsetExceptionMessages() {
        $expected = array(
            [
                'nome' => array(
                    'isEmpty' => 'Valor vazio',
                ),
                'email' => array(
                    'isEmpty' => 'Valor vazio',
                ),
            ]
        );
        
        $exc = new InvalidInputsetException();
        $exc->setValidatorMessages($expected);
        
        $this->assertEquals($expected, $exc->getValidatorMessages());
    }
    
    public function testInvalidReturnDataTypeException() {
        $exc = new InvalidReturnDataTypeException();
        $this->setExpectedException(InvalidReturnDataTypeException::class, '', Exception::INVALID_RETURN_DATATYPE);
        throw $exc;
    }

}
