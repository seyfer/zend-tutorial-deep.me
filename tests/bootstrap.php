<?php

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define path to application root
defined('APPLICATION_ROOT') || define('APPLICATION_ROOT', realpath(dirname(__FILE__) . '/..'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_ROOT . '/library'),
    get_include_path(),
)));

//require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setDefaultAutoloader(create_function('$class', "include str_replace('_', '/', \$class) . '.php';"));


$application = new Zend_Application(
        APPLICATION_ENV, APPLICATION_PATH . '/config/application.ini'
);

$application->bootstrap();
