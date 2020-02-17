<?php 

spl_autoload_register('myAutoLoader');

    function myAutoLoader($className) {
        $path = "classes/";
        $extension = ".class.php";
        // $fullPath = str_replace("\\", "/", $className) . $extension;
        $fullPath = $path . $className . $extension;


        //det här snyggar till error-meddelandet ifall nåt har gått fel
        if (!file_exists($fullPath)) {
            return false;
        }

        include_once $fullPath;
    }

    // str_replace("\\", "/", $className)

?>