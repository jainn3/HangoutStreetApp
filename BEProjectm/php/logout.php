<?php 
session_start();
session_destroy();
   header("Location:https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/BEProject/php/newdemo.php");

?>