<?php

namespace Chiquitto\Soul\Exception;

use Exception as PhpException;

/**
 * Description of Exception
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Exception extends PhpException
{

    /**
     * Excecao lancada para metodos que retornam tipos invalidos
     */
    const INVALID_RETURN_DATATYPE = 1001;

    /**
     * Lancado para dados que nao foram aprovados por \Chiquitto\Soul\Model\Vo\ValidatorItem::isValid()
     */
    const INVALID_INPUT_VALIDATOR = 1002;

    /**
     * Lancado para parametros/valores de entrada invalidos de metodos
     */
    const INVALID_ARGUMENT = 1003;

    /**
     * Lancado quando dados que o usuario forneceu sao invalidos
     */
    const INVALID_DATA_USER = 1004;

    /**
     * Lancado para dados que nao foram aprovados por \Chiquitto\Soul\Model\Vo\ValidatorItemset::isValid()
     */
    const INVALID_INPUT_VALIDATOR_SET = 1005;

    /**
     * Lancado quando o adaptador de db lancou uma excecao
     */
    const INVALID_QUERY = 1006;

    /**
     * Throw when user has insufficient privileges for resource access
     * \Chiquitto\Soul\Acl\Adapter\Exception\InsufficientPrivilegesResourceException
     */
    const INSUFFICIENT_PRIVILEGE_RESOURCE = 1007;
    
    /**
     * Throw when solicited resource isnt defined
     * \Chiquitto\Soul\Acl\Adapter\Exception\UndefinedResourceException
     */
    const UNDEFINED_RESOURCE = 1008;

    protected $defaultCode = null;
    protected $defaultMessage = null;

    public function __construct($message = "", $code = 0, PhpException $previous = null)
    {
        if (!$message) {
            $message = $this->defaultMessage;
        }
        parent::__construct($message, $this->defaultCode, $previous);
    }

}
