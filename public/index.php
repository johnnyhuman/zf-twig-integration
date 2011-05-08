<?php

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Page generation time counter
$_ENV['REQUEST_TIME'] = microtime(true);

// Define  document root path
define('ROOT_PATH',
    rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')), '/'));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', ROOT_PATH . '/application');

// Define other paths
define('DATA_PATH', ROOT_PATH . '/data');
define('CACHE_PATH', DATA_PATH . '/cache');
define('LIBRARY_PATH', ROOT_PATH . '/library');
define('MYPROJECT_PATH', LIBRARY_PATH . '/MyProject');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(LIBRARY_PATH),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
/** Common functions */
require_once 'MyProject/Functions.php';

// Create application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrap and run application
$application->bootstrap()
            ->run();

// Display stats
debug_print_stats();

// Wanna see included files? Uncomment this:
//debug_print_included_files(ROOT_PATH);

