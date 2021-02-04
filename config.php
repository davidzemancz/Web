<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'web');
/*
define('DB_SERVER', 'md22.wedos.net');
define('DB_USERNAME', 'w258715_dz');
define('DB_PASSWORD', 'rU3CGAPU');
define('DB_NAME', ' d258715_dz');
*/
 
// Create connection
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>