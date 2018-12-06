<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
foreach(glob('scripts/*') as $dir){
    if(file_exists($dir . '/' . basename($dir) . '.php')){
        include_once $dir . '/' . basename($dir) . '.php';
    }
}
