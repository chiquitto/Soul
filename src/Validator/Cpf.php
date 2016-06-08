<?php

namespace Chiquitto\Soul\Validator;

use Zend\Validator\AbstractValidator as ZendAbstractValidator;
use Zend\Validator\Exception;

/**
 * Description of Cpf
 *
 * @author chiquitto
 */
class Cpf extends AbstractCpfCnpj
{
    protected $_size = 11;

    protected $_modifiers = array(
        array(10, 9, 8, 7, 6, 5, 4, 3, 2),
        array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2)
    );
}
