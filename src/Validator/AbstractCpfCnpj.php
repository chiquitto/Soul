<?php

namespace Chiquitto\Soul\Validator;

use Zend\Validator\AbstractValidator as ZendAbstractValidator;
use Zend\Validator\Exception;

/**
 * Description of Cpf
 *
 * @author chiquitto
 */
abstract class AbstractCpfCnpj extends ZendAbstractValidator
{


    /**
     * Tamanho Inválido
     * @var string
     */
    const SIZE = 'size';

    /**
     * Números Expandidos
     * @var string
     */
    const EXPANDED = 'expanded';

    /**
     * Dígito Verificador
     * @var string
     */
    const DIGIT = 'digit';

    /**
     * Tamanho do Campo
     * @var int
     */
    protected $size = 0;

    /**
     * Modelos de Mensagens
     * @var string
     */
    protected $messageTemplates = array(
        self::SIZE     => "'%value%' não possui tamanho esperado",
        self::EXPANDED => "'%value%' não possui um formato aceitável",
        self::DIGIT    => "'%value%' não é um documento válido"
    );

    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $_modifiers = array();

    public function __construct($options = null)
    {
        if ($this instanceof Cpf) {
            $this->size = \Chiquitto\Soul\Util\Cpf::getSize();
        } else {
            $this->size = \Chiquitto\Soul\Util\Cnpj::getSize();
        }

        parent::__construct($options);
    }

    public function isValid($value)
    {
        // Verificação de Tamanho
        if (strlen($value) != $this->size) {
            $this->error(self::SIZE, $value);
            return false;
        }

        // Verificação de Dígitos Expandidos
        if (str_repeat($value[0], $this->size) == $value) {
            $this->error(self::EXPANDED, $value);
            return false;
        }

        // Verificação de Dígitos
        if ($this instanceof Cpf) {
            $ok = \Chiquitto\Soul\Util\Cpf::isValid($value);
        } else {
            $ok = \Chiquitto\Soul\Util\Cnpj::isValid($value);
        }

        if (!$ok) {
            $this->error(self::DIGIT, $value);
            return false;
        }

        return true;
    }

}
