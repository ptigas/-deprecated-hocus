<?php

// include libraries and classes
require_once 'includes.php';

// initialize database
ORM::configure('mysql:host=localhost;dbname=' . $mysql_database, null, 'remote');
ORM::configure('username', $mysql_username, 'remote');
ORM::configure('password', $mysql_password, 'remote');

?>