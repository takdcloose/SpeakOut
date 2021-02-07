<?php
session_start();
$_SESSION = array();
setcookie(session_name(),'',time()-2592000,'/');
session_destroy();
echo "<script> location.replace(\"../top.php\"); </script>";
?>
