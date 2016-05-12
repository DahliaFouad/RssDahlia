<?php
define('ROOT_DIR', dirname(__FILE__));
set_include_path('.'
. PATH_SEPARATOR . ROOT_DIR . '/library'
. PATH_SEPARATOR . ROOT_DIR . '/application/models'
. PATH_SEPARATOR . ROOT_DIR . '/application/forms'
. PATH_SEPARATOR . get_include_path());
require_once "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
$config = new Zend_Config_Ini(ROOT_DIR.'/application/config.ini', 'general');
$db = Zend_Db::factory($config->db);
Zend_Db_Table::setDefaultAdapter($db);
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory(ROOT_DIR.'/application/controllers');
$frontController->dispatch();
?>
