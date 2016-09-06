<?php

function Http_Autoloader($classname) {
  $pathParts = explode("\\", $classname);
  array_unshift($pathParts, 'src');
  $path = implode(DIRECTORY_SEPARATOR, $pathParts);
  $filename = __DIR__.DIRECTORY_SEPARATOR.$path.'.class.php';
  if (is_readable($filename)) {
    require_once $filename;
  }
}

spl_autoload_register('Http_Autoloader', true);
