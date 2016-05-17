<?php

namespace Chiquitto\Soul\Exception;

/**
 * Lancado para dados que nao foram aprovados por \Chiquitto\Soul\Model\Vo\ValidatorItem::isValid()
 */
class InvalidInputException extends Exception {

    protected $defaultCode = self::INVALID_INPUT_VALIDATOR;
    protected $defaultMessage = 'Entrada invalida para os validadores';
    private $validatorMessages = array();

    public function getValidatorMessages() {
        return $this->validatorMessages;
    }

    public function setValidatorMessages(array $validatorMessages) {
        $this->validatorMessages = $validatorMessages;
    }

}
