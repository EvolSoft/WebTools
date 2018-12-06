<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::addHook('script_init', array('UnitConverter', 'init'));

class UnitConverter {
    
    public static function init(){
        WebTools::addHook('init_navbar', array('UnitConverter', 'initNavbar'));
        WebTools::addToolItem('Unit Converter', '?page=unit-converter', 60);
        WebTools::registerPage('unit-converter', array('UnitConverter', 'onPage'), 'Unit Converter');
    }
    
    public static function onPage(){
        WebTools::addHook('init_header', array('UnitConverter', 'initHeader'));
        WebTools::addHook('draw_main_panel', array('UnitConverter', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initHeader(){
        echo '<script src="scripts/unitconverter/script.js"></script>';
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'Unit Converter', '?page=unit-converter', 60);
    }
    
    public static function drawMain($args){
        echo $args['before_title'] . 'Unit Converter' . $args['after_title'];?>
        <p>A powerful unit conversion tool.</p>
		<div id="unit_converter" style="display: none">
    		<div class="col-3 ns">
                <div class="list" id="units"></div>
    		</div>
    		<div class="col-9">
        		<div class="col-6"><h4>From:</h4></div>
                <div class="col-6"><h4>To:</h4></div>
                <div class="col-6"><input type="text" class="input" style="width: 100%" placeholder="Value" id="from"></div>
                <div class="col-6"><input type="text" class="input" style="width: 100%" placeholder="0" id="to" readonly></div>
                <div class="col-12"><br></div>
                <div class="col-6">
                    <select class="select" id="subunit_from"></select>
                </div>
                <div class="col-6">
                    <select class="select" id="subunit_to"></select>
                </div>
                <div class="col-12">
                	<br>
                	<button id="exchange" class="button button-primary full-width"><span class="fa fa-exchange"></span> Exchange</button>
                	<br>
                	<hr>
                	<table id="unit_table" class="table table-bordered table-selectable">
            			<tbody>
                            <tr>
                                <th scope="row">Unit</th>
                                <th>Value</th>
                            </tr>
                    	</tbody>
                    </table>
                </div>
    		</div>
		</div>
		<div id="js_alert" class="alert alert-error no-margins"><h4>JavaScript Required</h4><p>You must enable JavaScript on your browser to use this script!</p></div>
    	<?php
        echo $args['after_content'];
    }
}
