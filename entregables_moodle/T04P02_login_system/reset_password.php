<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Reset Password";
// include login checker
include_once "login_checker.php";
// include classes
include_once "config/database.php";
include_once "objects/user.php";
// get database connection
$database = new Database();
$db = $database->getConnection();
// initialize objects
$user = new User($db);
// include page header HTML
include_once "layout_head.php";
echo "<div class='col-sm-12'>";
    // check acess code will be here
echo "</div>";
// include page footer HTML
include_once "layout_foot.php";
?>