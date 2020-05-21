<?php 
ob_start();
$db['host'] = 'localhost';
$db['user'] = 'root';
$db['pass'] = '';
$db['name'] = 'test';
foreach($db as $key => $value)
{
    define(strtoupper($key),$value);
}

$connection = mysqli_connect(HOST,USER,PASS,NAME);
if(!$connection)
{
    echo "Connection to the server FAILED : " . mysqli_error($connection);
    echo mysqli_error($connection);
}
?>