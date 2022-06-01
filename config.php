<?php
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'admin');
define('DB_SERVER_PASSWORD', 'admin');
define('DB_DATABASE', 'tfg');
 
$connexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
?>
