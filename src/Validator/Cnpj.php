<?php

namespace Chiquitto\Soul\Validator;

use Zend\Validator\AbstractValidator as ZendAbstractValidator;
use Zend\Validator\Exception;

/**
 * Description of Cnpj
 *
 * @author chiquitto
 */
class Cnpj extends AbstractCpfCnpj
{
    protected $_size = 14;

    protected $_modifiers = array(
        array(5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2),
        array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2)
    );
}
