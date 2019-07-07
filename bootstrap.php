<?php

function load_classes() {

    $arrDirectories = ['models/interfaces', 'models', 'controllers', 'config'];

    foreach ($arrDirectories as $strDirectory)
    {

        $dir = __DIR__ . '/' . $strDirectory;

        foreach (scandir($dir) as $file)
        {
            if (in_array($file, array('.', '..')) || !preg_match("/.php$/i", $file))
            {
                continue;
            }

            require_once $dir . '/' . $file;
        }
    }
}

load_classes();

