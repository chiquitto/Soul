<?php

namespace Chiquitto\Soul\Model;

use Chiquitto\Soul\Db\TableGateway\TableGatewayFactory;
use Chiquitto\Soul\Db\TableGateway\TableGatewayTbconfig;
use Chiquitto\Soul\Util\ServiceLocatorFactory;
use Zend\Validator\Exception\InvalidArgumentException;

/**
 * Description of Config
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class Config {

    /**
     * Valor padrao: null
     */
    const TYPE_ARRAY = 'ARRAY';

    /**
     * Valor padrao: false
     */
    const TYPE_BOOLEAN = 'BOOLEAN';

    /**
     * Valor padrao: 0
     */
    const TYPE_FLOAT = 'FLOAT';

    /**
     * Valor padrao: 0
     */
    const TYPE_INT = 'INT';

    /**
     * Valor padrao: null
     */
    const TYPE_OBJECT = 'OBJECT';

    /**
     * Valor padrao: null
     */
    const TYPE_STRING = 'STRING';

    /**
     * Valor padrao: null
     */
    const TYPE_TEXT = 'TEXT';

    protected $cacheFile;
    private $config;

    /**
     *
     * @var TableGatewayTbconfig
     */
    private $tableGateway;

    /**
     * Valores padroes dos tipos/constantes
     *
     * @var array
     */
    protected $defaultValues;

    /**
     * Tipos dos parametros
     *
     * @var array
     */
    protected static $paramTypes = [];

    public function __construct() {
        $this->defaultValues = ((array) $this->defaultValues) + [
            self::TYPE_ARRAY => null,
            self::TYPE_BOOLEAN => false,
            self::TYPE_FLOAT => 0,
            self::TYPE_INT => 0,
            self::TYPE_OBJECT => null,
            self::TYPE_STRING => null,
            self::TYPE_TEXT => null,
        ];
        
        $config = ServiceLocatorFactory::getConfiguration();

        $this->loadValoresPadrao();
        $this->loadConfig();
    }
    
    public function clearCache()
    {
        $cacheFile = $this->getCacheFile();
        if (is_file($cacheFile)) {
            unlink($cacheFile);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function createCacheFile() {
        $this->config = array();
        
        // Popular config com valores padrao
        foreach (static::$paramTypes as $k => $v) {
            $this->config[$k] = $this->getVarPadrao($k);
        }

        // Sobrescrever com valores do BD
        $registros = $this->tableGatewaySelect();
        foreach ($registros as $registro) {
            if (!isset(static::$paramTypes[$registro['idconfig']])) {
                continue;
            }

            $idconfig = $registro['idconfig'];
            switch (static::$paramTypes[$idconfig]) {
                case self::TYPE_ARRAY:
                    $this->config[$idconfig] = json_decode($registro['sttext'], 1);
                    break;
                
                case self::TYPE_OBJECT:
                    $this->config[$idconfig] = json_decode($registro['sttext'], 0);
                    break;

                case self::TYPE_TEXT:
                    $this->config[$idconfig] = $registro['sttext'];
                    break;

                case self::TYPE_INT:
                    $this->config[$idconfig] = (int) $registro['stvalue'];
                    break;

                default:
                    $this->config[$idconfig] = $registro['stvalue'];
                    break;
            }
        }

        // Gerar JSON e Gravar no arquivo
        $this->flushCache();
    }
    
    /**
     * Refresh file cache
     */
    public function flushCache() {
        file_put_contents($this->cacheFile, serialize($this->config));
    }
    
    public function get($paramName, $default = null)
    {
        return $this->config[$paramName];
    }

    public function getAll()
    {
        return $this->config;
    }
    
    function getCacheFile() {
        return $this->cacheFile;
    }
    
    public static function getParamType($paramName) {
        return static::$paramTypes[$paramName];
    }

    private function getVarPadrao($k) {
        if (isset($this->defaultValues[$k])) {
            return $this->defaultValues[$k];
        }

        return $this->defaultValues[static::$paramTypes[$k]];
    }

    private function loadConfig() {
        if (!file_exists($this->cacheFile)) {
            $this->createCacheFile();
        } else {
            $this->config = unserialize(file_get_contents($this->cacheFile));
        }
    }

    private function loadValoresPadrao() {
        
    }

    public function set($paramName, $paramValue) {
        if (!isset(static::$paramTypes[$paramName])) {
            throw new InvalidArgumentException();
        }

        $paramType = static::$paramTypes[$paramName];

        // Tratamento do valor
        switch ($paramType) {
            case self::TYPE_BOOLEAN:
                $paramValue = (bool) $paramValue;
                break;
            
            case self::TYPE_FLOAT:
                $paramValue = (float) $paramValue;
                break;
            
            case self::TYPE_INT:
                $paramValue = (int) $paramValue;
                break;
        }

        $this->config[$paramName] = $paramValue;

        // Definir valor no BD
        $stvalue = null;
        $sttext = null;
        switch ($paramType) {
            case self::TYPE_BOOLEAN:
                $stvalue = $paramValue ? 1 : 0;
                break;
            
            case self::TYPE_FLOAT:
            case self::TYPE_INT:
            case self::TYPE_STRING:
                $stvalue = $paramValue;
                break;
            
            case self::TYPE_ARRAY:
            case self::TYPE_OBJECT:
                $sttext = json_encode($paramValue);
                break;
        }

        $this->tableGatewayDelete($paramName);
        $this->tableGatewayInsert([
            'idconfig' => $paramName,
            'stvalue' => $stvalue,
            'sttext' => $sttext,
        ]);
    }

    protected function tableGateway() {
        if (!$this->tableGateway) {
            $this->tableGateway = TableGatewayFactory::factoryClass(TableGatewayTbconfig::class);
        }
        return $this->tableGateway;
    }
    
    protected function tableGatewayDelete($paramName) {
        return $this->tableGateway()->delete("idconfig = '{$paramName}'");
    }
    
    protected function tableGatewayInsert($set) {
        return $this->tableGateway()->insert($set);
    }
    
    protected function tableGatewaySelect() {
        return $this->tableGateway()->select();
    }

}
