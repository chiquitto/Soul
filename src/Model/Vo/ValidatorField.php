<?php

namespace Soul\Model\Vo;

use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

/**
 * Classe que contem a validacao e filtros para um atributo de DinaZend\Model\Vo\ValidatorItem
 *
 * @codeCoverageIgnore
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class ValidatorField {

    /**
     *
     * @var ValidatorChain
     */
    private $validatorChain;

    public function attachValidate(ValidatorInterface $validator) {
        if (!$this->validatorChain instanceof ValidatorChain) {
            $this->validatorChain = new ValidatorChain();
        }

        $this->validatorChain->attach($validator);
    }

    /**
     * 
     * @return ValidatorChain
     */
    public function getValidatorChain() {
        return $this->validatorChain;
    }

}
