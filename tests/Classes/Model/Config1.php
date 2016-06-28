<?php

namespace Chiquitto\SoulTest\Classes\Model;

use Chiquitto\Soul\Model\Config as SoulConfig;

/**
 * Description of Config1
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Config1 extends SoulConfig
{
    const PARAM_BOOLEAN_F = 'BOOLEAN_F';
    const PARAM_BOOLEAN_T = 'BOOLEAN_T';
    const PARAM_CLIENT = 'CLIENT';
    const PARAM_ID = 'ID';
    const PARAM_LIST = 'LIST';
    const PARAM_NAME = 'NAME';
    const PARAM_VALUE = 'VALUE';

    protected static $paramTypes = [
        self::PARAM_BOOLEAN_F => self::TYPE_BOOLEAN,
        self::PARAM_BOOLEAN_T => self::TYPE_BOOLEAN,
        self::PARAM_CLIENT => self::TYPE_OBJECT,
        self::PARAM_ID => self::TYPE_INT,
        self::PARAM_LIST => self::TYPE_ARRAY,
        self::PARAM_NAME => self::TYPE_STRING,
        self::PARAM_VALUE => self::TYPE_FLOAT,
    ];
    private static $instance;
    protected $defaultValues = [
        self::PARAM_BOOLEAN_T => true,
    ];

    public function __construct()
    {
        $this->cacheFile = \Chiquitto\Soul\PATH_TMP . '/config.serialized';

        parent::__construct();
    }

    /**
     *
     * @return Config1
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function clearInstance()
    {
        self::$instance = null;
    }


}