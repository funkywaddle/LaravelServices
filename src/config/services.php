<?php

$dir = app_path() . '/ServiceProviders';
$sps = array_diff(scandir($dir), ['.','..']);
$serviceProviders = [];
foreach($sps as $key=>$file) {
    $class = explode('.', $file);

    if($class[1] == 'php'){
        $serviceProviders[] = 'App\\ServiceProviders\\' . $class[0];
    }
}

return $serviceProviders;