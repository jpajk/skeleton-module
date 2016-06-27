<?php

if (!defined('_PS_VERSION_'))
	exit;

spl_autoload_register(function($className) {
	$dir = __DIR__ . '/../' ;
	$filename = $dir . str_replace('\\', '/', $className) . ".php";
            
        if (file_exists($filename)) {
            include $filename;


            if (class_exists($className)) {
                return true;
            }
        }

        return false;
	
});

class skeletonmodule extends skeletonmodule\SkeletonModuleBase
{	
}