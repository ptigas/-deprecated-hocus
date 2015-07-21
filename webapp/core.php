<?php

// include settings
require_once 'settings.php';

// set include path
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));

// include libraries and classes
require_once 'includes.php';

// set template
$twig_loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/templates');
$twig = new Twig_Environment($twig_loader, array(
    'cache' => $template_cache ? dirname(__FILE__) . '/compilation_cache' : false,
));

// initialize database
ORM::configure('mysql:host=localhost;dbname=' . $mysql_database, null, 'remote');
ORM::configure('username', $mysql_username, 'remote');
ORM::configure('password', $mysql_password, 'remote');

?>