<?php

function autoload_class_multiple_directory() {

    # List all the class directories in the array.
    // $array_paths = array(
    //     'clases',
    //     'clases2'
    // );
    // $classDir = dirname(__FILE__);
    // echo var_dump($files);
    // foreach($array_paths as $path) {
    //     $file = sprintf('%s/%s/%s.php', $classDir, $path, $nomclase);
    //     // echo "<br>" . $file;
    //     if(is_file($file)) {
    //         include_once $file;
    //     }

    // }

    require_once __DIR__ . '/autoload_files.php';
    $files = Autoload_files::$files;

    foreach($files as $fileIdentifier => $file) {
        // echo "<br>" . $file;
        if(is_file($file)) {
            include_once $file;
        }
    }
}

spl_autoload_register('autoload_class_multiple_directory');
