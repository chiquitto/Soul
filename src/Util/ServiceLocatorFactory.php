<?php

/**
 * @link https://github.com/fezfez/ServiceLocatorFactory
 * @link https://github.com/fezfez/ServiceLocatorFactory/blob/master/src/ServiceLocatorFactory/ServiceLocatorFactory.php
 */

namespace Chiquitto\Soul\Util;

use Exception;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

/**
 * @codeCoverageIgnore
 */
class ServiceLocatorFactory {

    /**
     * @var ServiceManager
     */
    private static $serviceManager = null;

    /**
     * Disable constructor
     */
    private function __construct() {
        
    }

    public static function get($key) {
        return static::getInstance()->get($key);
    }

    /**
     * Retorna uma instancia do servico Application
     * 
     * @return Application
     */
    public static function getApplication() {
        return static::getInstance()->get('Application');
    }

    public static function getConfiguration($key = null) {
        $config = static::getInstance()->get('Configuration');
        return ($key === null) ? $config : $config[$key];
    }

    /**
     * @throw \Exception
     * @return ServiceManager
     */
    public static function getInstance() {
        if (null === static::$serviceManager) {
            throw new Exception('ServiceLocator is not set');
        }
        return static::$serviceManager;
    }

    /**
     * @param ServiceManager
     */
    public static function setInstance(ServiceManager $sm) {
        static::$serviceManager = $sm;
    }

}
