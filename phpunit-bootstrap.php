<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//set_time_limit(0);
//date_default_timezone_set('America/Sao_Paulo');
//header('content-type:text/html;charset=iso-8859-1');

require 'vendor/autoload.php';

use Chiquitto\Soul\Util\ServiceLocatorFactory;
use Zend\ServiceManager\ServiceManager;
use const Chiquitto\Soul\PATH_TESTS;

class Bootstrap
{

    public static function init()
    {
        $testConfig = require PATH_TESTS . '/config/application.config.php';

        $serviceManager = new ServiceManager($testConfig);
        $serviceManager->setService('Configuration', $testConfig);

        ServiceLocatorFactory::setInstance($serviceManager);
    }

}

Bootstrap::init();