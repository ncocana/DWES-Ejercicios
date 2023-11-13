<?php
// show error reporting
error_reporting(E_ALL);
// start php session
session_start();
// set your default time-zone
date_default_timezone_set('Europe/Madrid');
// Determine the current domain
if ($_SERVER['HTTP_HOST'] === 'ncocana.randion.es') {
    $domain = "ncocana.randion.es";
    // home page url
    $home_url = "http://" . $domain . "/dwes/ejercicios-1ra-eva-ncocana/entregables_moodle/T04P02_login_system/";
} else if ($_SERVER['HTTP_HOST'] === 'ncocana_login.randion.es') {
    $domain = "ncocana_login.randion.es";
    // home page url
    $home_url = "http://" . $domain . "/";
} else {
    // Default URL for unknown domains and localhost
    $domain = "localhost";
    // home page url
    $home_url = "http://" . $domain . "/dwes/ejercicios-1ra-eva-ncocana/entregables_moodle/T04P02_login_system/";
}
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 5;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>
