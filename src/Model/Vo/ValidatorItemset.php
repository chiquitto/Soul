<?php

namespace Chiquitto\Soul\Model\Vo;

use Chiquitto\Soul\Exception\InvalidInputException;
use Chiquitto\Soul\Exception\InvalidInputsetException;
use Chiquitto\Soul\Validator\Itemset\AbstractValidator;
use Zend\Validator\ValidatorChain;

/**
 * Classe para validar um DinaZend\Model\Vo\Item
 * 
 * @codeCoverageIgnore
 */
class ValidatorItemset {

    /**
     *
     * @var ValidatorItem
     */
    private $validatorItem;

    /**
     * @var ValidatorChain
     */
    private $validatorChain = array();

    public function __construct() {
        $this->validatorItem = new ValidatorItem();
    }

    public function addValidatorFieldset(AbstractValidator $validator) {
        if (!$this->validatorChain) {
            $this->validatorChain = new ValidatorChain();
        }

        $this->validatorChain->attach($validator);
        return true;
    }

    public function isValid(Itemset $itemset) {
        $this->messages = array();

        $isValid = true;

        if ($this->validatorChain) {
            if (!$this->validatorChain->isValid($itemset)) {
                $this->messages['itemset'] = $this->validatorChain->getMessages();
                $isValid = false;
            }

            if (!$isValid) {
                $exc = new InvalidInputException;
                $exc->setValidatorMessages($this->messages);
                throw $exc;
            }
        }

        foreach ($itemset as $k => $itemVo) {
            /* @var $itemVo Item */

            $this->messages[$k] = [];

            try {
                $this->validatorItem->isValid($itemVo);
            } catch (InvalidInputException $exc) {
                $isValid = false;
                $this->messages[$k] = $this->validatorItem->getMessages();
            }
        }

        if (!$isValid) {
            $exc = new InvalidInputsetException();
            $exc->setValidatorMessages($this->messages);
            throw $exc;
        }

        return true;
    }

    public function setValidatorField($fieldName, ValidatorField $validator) {
        $this->validatorItem->setValidatorField($fieldName, $validator);
        return true;
    }

}
