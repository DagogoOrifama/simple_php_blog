<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
$_SESSION['user_id'] = NULL;
session_destroy();
redirect_to("login.php");


?>