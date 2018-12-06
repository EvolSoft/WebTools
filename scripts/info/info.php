<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::addHook('script_init', array('InfoScript', 'init'));

class InfoScript {
    
    public static function init(){
        WebTools::addHook('init_navbar_after', array('InfoScript', 'initNavbar'));
        WebTools::registerPage('info', array('InfoScript', 'onPage'), 'Info');
    }
    
    public static function onPage(){
        WebTools::addHook('draw_main_panel', array('InfoScript', 'drawMain'));
        WebTools::addHook('end_page', array('InfoScript', 'beforeBody'));
    }
    
    public static function initNavbar(){
        WebTools::createNavItem('Info', '?page=info', 20);
    }
    
    public static function drawMain($args){
        echo $args['before_title'] . 'WebTools Informations' . $args['after_title'];?>
        <p><b>WebTools</b> is an <i>open-source</i> comprehensive collection of useful tools written in PHP and JavaScript.<br>Currently it includes:</p>
        <ul>
        	<li>A tool to show your IP address information</li>
        	<li>A URL to IP converter tool</li>
        	<li>A <a href="https://www.evolsoft.tk/phartools" target="_blank">PharTools</a> based PHP-archive extractor (*.phar) tool</li>
        	<li>A simple password generator</li>
        	<li>A more advanced password generator</li>
        	<li>A powerful unit converter tool</li>
        </ul>
        <br>
        <p>Other tools will be added later. Adding tools is very easy thanks to the simple API included in <b>WebTools</b> allowing the creation of new tools/scripts without modifying the WebTools core source code.<br></p>
        <center>
    		<a class="github-button" href="https://github.com/EvolSoft/WebTools/subscription" data-icon="octicon-eye" data-show-count="true" aria-label="Watch EvolSoft/WebTools on GitHub">Watch</a>
    		<a class="github-button" href="https://github.com/EvolSoft/WebTools" data-icon="octicon-star" data-show-count="true" aria-label="Star EvolSoft/WebTools on GitHub">Star</a>
    		<a class="github-button" href="https://github.com/EvolSoft/WebTools/fork" data-icon="octicon-repo-forked" data-show-count="true" aria-label="Fork EvolSoft/WebTools on GitHub">Fork</a>
        </center>
        <p>You can find the official <b>WebTools</b> source at: <a href="https://github.com/EvolSoft/WebTools">https://github.com/EvolSoft/WebTools</a>.<br>
        Feel free to contribute to <b>WebTools</b> source code and also give a star to the project if you want to <span class="fa fa-smile-o fa-lg out-warning"></span>.</p>
        <?php echo $args['after_content'];?>
        <div class="panel panel-default">
            <div class="panel-header"><h3 class="panel-title">Changelog</h3></div>
            <div class="panel-content">
				<b>1.0.0</b> - 18/03/2017:<br>
            	- First release
            </div>
        </div>
        <?php
    }
    
    public static function beforeBody(){?>
        <script async defer src="https://buttons.github.io/buttons.js"></script><?php
    }
}