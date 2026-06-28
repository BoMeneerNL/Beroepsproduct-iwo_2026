<?php
/* 
*    to use this as env file, copy this file in the src directory and rename it to env.php
*    if used in Docker context the host is the name of the service in the docker-compose file,
*    not localhost
*/
require_once 'utils.php';
disallowDirectAccess(__FILE__);
$db_host = "mariadb";
$db_port = 3306;
$db_database="pizzeria";
$db_user = "user";
$db_pass = "password";