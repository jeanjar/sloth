<?php

include('boot.php');

function __autoload($class)
{
     include __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . strtr($class, '_', DIRECTORY_SEPARATOR) . '.php';
}
