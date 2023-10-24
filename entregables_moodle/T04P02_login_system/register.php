<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Register";
// include login checker
include_once "login_checker.php";
// include classes
include_once 'config/database.php';
include_once 'objects/user.php';
include_once "libs/php/utils.php";
// include page header HTML
include_once "layout_head.php";
echo "<div class='col-md-12'>";
    // registration form HTML will be here
echo "</div>";
// include page footer HTML
include_once "layout_foot.php";
?>