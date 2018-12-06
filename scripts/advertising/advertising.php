<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once WebTools::getScriptPath(__FILE__) . 'config.php';
WebTools::addHook('script_init', array('AdvertisingScript', 'init'));

class AdvertisingScript {
    
    public static function init(){
        WebTools::addHook('init_header', array('AdvertisingScript', 'initHeader'));
        WebTools::addHook('draw_panels_dx_before', array('AdvertisingScript', 'drawPanel'));
    }
    
    public static function initHeader(){
        global $config;
        echo $config['advertising']['adsense-script'];
    }
    
    public static function drawPanel(){
        global $config;?>
        <div class="panel panel-warning-lt">
            <div class="panel-header">
                <h3 class="panel-title">Advertising</h3>
            </div>
            <div class="panel-content">
            	<center>
            		<?php echo $config['advertising']['adsense-banner'];?>
            	</center>
            </div>
        </div><?php
    }
}