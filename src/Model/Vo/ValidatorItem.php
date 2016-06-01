<?php

namespace Chiquitto\Soul\Model\Vo;

use Chiquitto\Soul\Exception\InvalidInputException;
use Zend\Filter\FilterChain;
use Zend\Validator\ValidatorChain;

/**
 * Classe para validar um DinaZend\Model\Vo\Item
 * 
 * @codeCoverageIgnore
 */
class ValidatorItem {

    private $messages = array();

    /**
     * Array com ValidatorField
     *
     * @var array
     */
    private $validators = array();

    public function getMessages() {
        return $this->messages;
    }

    /**
     * 
     * @param \Chiquitto\Soul\Model\Vo\Item $itemVo
     * @return boolean
     * @throws InvalidInputException
     */
    public function isValid(Item $itemVo) {
        $this->messages = array();
        
        $isValid = true;
        foreach ($this->validators as $fieldName => $validatorField) {
            /* @var $validatorField ValidatorField */
            $isValid = $this->isValidValidator($fieldName, $itemVo, $validatorField) && $isValid;
            
            if ((!$isValid) && ($validatorField->isBreakChainOnFailure())) {
                break;
            }
        }

        if (!$isValid) {
            $exc = new InvalidInputException;
            $exc->setValidatorMessages($this->messages);
            throw $exc;
        }

        return true;
    }

    private function isValidValidator($fieldName, Item $itemVo, ValidatorField $validatorField) {        
        if ($filterChain = $validatorField->getFilterChain()) {
            /* @var $filterChain FilterChain */
            $v = $itemVo->get($fieldName);
            $r = $filterChain->filter($v);
            $itemVo->set($fieldName, $r);
        }
        
        if ($validatorChain = $validatorField->getValidatorChain()) {
            /* @var $validatorChain ValidatorChain */
            if (!$validatorChain->isValid($itemVo->get($fieldName))) {
                $this->messages[$fieldName] = $validatorChain->getMessages();
                return false;
            }
        }
        return true;
    }

    public function setValidatorField($fieldName, ValidatorField $validator) {
        $this->validators[$fieldName] = $validator;
        return true;
    }

}
