<?php

namespace Chiquitto\Soul\Model\Vo;

use Zend\Filter\FilterChain;
use Zend\Filter\FilterInterface;
use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

/**
 * Classe que contem a validacao e filtros para um atributo de Chiquitto\Soul\Model\Vo\Item
 *
 * @codeCoverageIgnore
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class ValidatorField
{

    private $breakChainOnFailure;

    /**
     *
     * @var FilterChain
     */
    private $filterChain;

    /**
     *
     * @var ValidatorChain
     */
    private $validatorChain;
    
    public function attachFilter(FilterInterface $filter) {
        if (!$this->filterChain instanceof FilterChain) {
            $this->filterChain = new FilterChain();
        }

        $this->filterChain->attach($filter);
    }

    public function attachValidate(ValidatorInterface $validator, $breakChainOnFailure = false)
    {
        if (!$this->validatorChain instanceof ValidatorChain) {
            $this->validatorChain = new ValidatorChain();
        }

        $this->validatorChain->attach($validator, $breakChainOnFailure);
    }
    
    /**
     * 
     * @return FilterChain
     */
    public function getFilterChain()
    {
        return $this->filterChain;
    }

    /**
     * 
     * @return ValidatorChain
     */
    public function getValidatorChain()
    {
        return $this->validatorChain;
    }

    public function isBreakChainOnFailure()
    {
        return $this->breakChainOnFailure;
    }

    public function setBreakChainOnFailure($breakChainOnFailure)
    {
        $this->breakChainOnFailure = $breakChainOnFailure;
    }

}
