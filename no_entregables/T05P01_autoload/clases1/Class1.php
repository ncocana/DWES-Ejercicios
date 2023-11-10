<?php

// namespace Example\Test;

// use Exception;

class Class1
{

    // private static ?Autoloader $instance = null;

    // function __construct()
    // {
    //     spl_autoload_register([$this, 'autoload']);
    // }

    // public function autoload($class)
    // {

    //     $parts = explode('\\', $class);
    //     if ($parts[0] != 'Example' || $parts[1] != 'Test') {
    //         throw new Exception('All classes must be on "Example\Test" Namespace.
    //                                     <br> Namespace Used: ' . implode('\\', $parts));
    //     }
    //     unset($parts[0], $parts[1]);
    //     $filename = implode('/', $parts) . '.php';
    //     if (file_exists($filename)) {
    //         /** @noinspection PhpIncludeInspection */
    //         require_once($filename);
    //     } else {
    //         throw new Exception('Class File not Found: ' . $filename);
    //     }
    // }

    // public static function getInstance(): Autoloader
    // {
    //     if (!self::$instance instanceof self) self::$instance = new self;
    //     return self::$instance;
    // }

    public function echoS()
    {
        echo "<p>Sí funciona. Esto viene de la funcion echoS() de la clase Autoloader1.</p>";
    }
}


