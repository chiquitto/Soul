<?php

/**
 * If you need an environment-specific system or application configuration,
 * there is an example in the documentation
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html#environment-specific-system-configuration
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html#environment-specific-application-configuration
 */
return array(
    'modules' => array(),
    'module_listener_options' => array(
        'module_paths' => array(),
        'config_glob_paths' => array(),
    ),
    'db' => array(
        'default' => [
            'driver' => 'Pdo_Sqlite',
            'database' => \Chiquitto\Soul\PATH_TMP . '/data.sqlite.db',
            'dsn' => 'sqlite:' . \Chiquitto\Soul\PATH_TMP . '/data.sqlite.db',
        ]
    ),
    'factories' => array(
        'Zend\Db\Adapter\Adapter' => 'Chiquitto\Soul\Db\Adapter\AdapterFactory',
        'Zend\Db\Adapter\AdapterDdl' => 'Chiquitto\Soul\Db\Adapter\AdapterDdlFactory',
        'Zend\Db\Adapter\AdapterWrite' => 'Chiquitto\Soul\Db\Adapter\AdapterWriteFactory',
    ),
);
