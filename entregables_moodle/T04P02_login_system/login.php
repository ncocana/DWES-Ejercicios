<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Login";
// include login checker
$require_login=false;
include_once "login_checker.php";
// default to false
$access_denied=false;
// post code will be here
// login form html will be here
?>