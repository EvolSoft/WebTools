<?php
//Temporary uploaded phar files directory
$config['pharextractor']['temp_folder'] = 'tmp/';
//Extracted phar files directory
$config['pharextractor']['data_folder'] = 'extracted/';
//Extracted phar files cache time in seconds (0 to disable this feature)
$config['pharextractor']['cache_time'] = 60;
//Maximum upload file size (0 to disable this feature. If 0, the maximum upload file size will be the maximum specified on php.ini file)
$config['pharextractor']['max_upload'] = 0;