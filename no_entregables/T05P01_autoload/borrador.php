<?php
    // $nomclase = "Autoloader";
    // $nomclase2 = "Autoloader2";


    // function __spl_autoload_register($nomclase){
    //     // la siguiente línea se adaptará para que genere una cadena adecuada para
    //     // encontrar la clase.
    //     $nomclase= str_replace ("..", "", $nomclase);
    //     require_once($_SERVER['DOCUMENT_ROOT']."/clases/$nomclase.php");
    // };
    // spl_autoload_register(function ($nomclase) {
    //     include 'clases/' . $nomclase. '.php';
    // });
    // spl_autoload_register($nomclase);

    
    // use Example\Test;

    // require_once './clases/Autoloader.php';
    // Autoloader::getInstance();


    // function my_loader($nomclase) {
    //     if (file_exists("clases/$nomclase.php")) {
    //             include "clases/$nomclase.php";
    //     }
    //     // else {
    //     //     echo "<p>No funciona</p>";
    //     // }
    // }
    // function your_loader($nomclase2) {
    //     include "clases2/$nomclase2.php";
    // }
    // spl_autoload_register("my_loader");
    // spl_autoload_register("your_loader");
    // spl_autoload_register("my_loader" | "your_loader");
    // include "clases/Autoloader.php";


    // $classDirPrueba = dirname(__DIR__);
    // $baseDirPrueba = dirname($classDirPrueba);
    // echo $classDirPrueba . "<br>" . $baseDirPrueba . "<br>" . dirname(__FILE__);


    // $classDir = dirname(__FILE__);
    // $arrayClass = array(
    //     'class1' => $classDir . '/clases/Autoloader.php',
    //     'class2' => $classDir . '/clases/Autoloader3.php',
    //     // '6e3fae29631ef280660b3cdad06f25a8' => $classDir . '/clases2/Autoloader2.php',
    //     // 'e69f7f6ee287b969198c3c9d6777bd38' => $classDir . '/clases3/autoload_files.php',
    // );
    // function array_loader($arrayClass) {
    //     for( $i = 0; $i < count($arrayClass); $i++ ) {
    //         include_once "clases/" . $arrayClass[$i] . ".php";
    //         echo $arrayClass[$i];
    //     }
    // }
    // var_dump($arrayClass);
    // spl_autoload_register("array_loader");


    // function autoload_class_multiple_directory($nomclase)
    // {

    //     # List all the class directories in the array.
    //     // $array_paths = array(
    //     //     'clases',
    //     //     'clases2'
    //     // );
    //     // $classDir = dirname(__FILE__);
    //     // echo var_dump($files);
    //     // foreach($array_paths as $path) {
    //     //     $file = sprintf('%s/%s/%s.php', $classDir, $path, $nomclase);
    //     //     // echo "<br>" . $file;
    //     //     if(is_file($file)) {
    //     //         include_once $file;
    //     //     }

    //     // }

    //     require_once __DIR__ . '/autoload/autoload_files.php';
    //     $files = Autoloader_files::$files;

    //     foreach($files as $file) {
    //         // echo "<br>" . $file;
    //         if(is_file($file)) {
    //             include_once $file;
    //         }

    //     }
    // }

    // spl_autoload_register('autoload_class_multiple_directory');
    require_once __DIR__.'/autoload/autoload.php';

    $obj = new Class1();
    $obj->echoS();
    $obj2 = new Class2();
    $obj2->echoS();
    $obj3 = new Class3();
    $obj3->echoS();
?>