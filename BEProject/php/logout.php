<?php 
session_start();
include_once ('../php_files/guser.php');
logout();
session_destroy();
   header("Location:https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/Hangoutstreet/BEProject/php/newdemo.php");

?>