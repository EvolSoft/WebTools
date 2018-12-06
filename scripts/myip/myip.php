<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once WebTools::getScriptPath(__FILE__) . 'config.php';
WebTools::addHook('script_init', array('MyIP', 'init'));

class MyIP {
    
    public static function init(){
        WebTools::addHook('init_navbar', array('MyIP', 'initNavbar'));
        WebTools::addToolItem('MyIP', '?page=my-ip', 10);
        WebTools::registerPage('my-ip', array('MyIP', 'onPage'), 'MyIP');
    }
    
    public static function onPage(){
        WebTools::addHook('init_header', array('MyIP', 'initHeader'));
        WebTools::addHook('draw_main_panel', array('MyIP', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'MyIP', '?page=my-ip', 10);
    }
    
    public static function initHeader(){
        echo '<script src="scripts/myip/script.js"></script>';
    }
    
    public static function drawMain($args){
        global $config;
        $apikey = $config['myip']['maps_api_key'];
        echo $args['before_title'] . 'MyIP' . $args['after_title'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['REMOTE_HOST'])) $host = $_SERVER['REMOTE_HOST'];
        $port = $_SERVER['REMOTE_PORT'];
        //$loc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
        $loc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=93.40.198.96'));
        $country = $loc['geoplugin_countryName'];
        $region = $loc['geoplugin_regionName'];
        $city = $loc['geoplugin_city'];
        $latitude = $loc['geoplugin_latitude'];
        $longitude = $loc['geoplugin_longitude'];
        $isp = gethostbyaddr($ip);
        ?>
        <div>
        	<p>Get informations about your IP address.</p>
            <h4>IP informations:</h4>
            <table id="myip-table" class="table table-bordered table-selectable">
                <tbody>
                    <tr>
                        <th scope="row">IP address</th>
                        <td><?php echo $ip ? $ip : 'Unknown';?></td>
                    </tr>
                    <?php if(isset($_SERVER['REMOTE_HOST'])){?>
                    <tr>
                        <th scope="row">Host</th>
                        <td><?php echo $host ? $host : 'Unknown';?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <th scope="row">Remote port</th>
                        <td><?php echo $port ? $port : 'Unknown';?></td>
                	</tr>
                    <tr>
                        <th scope="row">Country</th>
                        <td><?php echo $country ? $country : 'Unknown';?></td>
                    </tr>
                    <tr>
                        <th scope="row">Region</th>
                        <td><?php echo $region ? $region : 'Unknown';?></td>
                    </tr>
                    <tr>
                        <th scope="row">City</th>
                        <td><?php echo $city ? $city : 'Unknown';?></td>
                    </tr>
                    <tr>
                        <th scope="row">Latitude</th>
                        <td><?php echo $latitude ? $latitude : 'Unknown';?></td>
                    </tr>
                    <tr>
                        <th scope="row">Longitude</th>
                        <td><?php echo $longitude ? $longitude : 'Unknown';?></td>
                    </tr>
                    <tr>
                        <th scope="row">ISP</th>
                        <td><?php echo $isp ? $isp : 'Unknown';?></td>
                    </tr>
            	</tbody>
            </table>
            <?php if($apikey && $longitude && $latitude){?>
            <h4>IP Location:</h4>
            <center><img border="0" src="https://maps.googleapis.com/maps/api/staticmap?markers=color:red|<?php echo $latitude . ',' . $longitude;?>&amp;zoom=12&amp;size=500x500&key=<?php echo $apikey;?>"></center>
            <?php }?>
            <h4>Headers:</h4>
            <table id="headers-table" class="table table-bordered table-selectable">
            	<tbody>
            		<tr>
            			<td><?php
            			$httph = getallheaders();
            			if(isset($httph['User-Agent'])) echo '<b>User-Agent:</b> ' . $httph['User-Agent'] . '<br>';
            			if(isset($httph['Accept'])) echo '<b>Accept:</b> ' . $httph['Accept'] . '<br>';
            			if(isset($httph['Accept-Encoding'])) echo '<b>Accept-Encoding:</b> ' . $httph['Accept-Encoding'] . '<br>';
            			if(isset($httph['Accept-Language'])) echo '<b>Accept-Language:</b> ' . $httph['Accept-Language'] . '<br>';
            			if(isset($httph['Cookie'])) echo '<b>Cookie:</b> ' . $httph['Cookie'] . '<br>';
            			if(isset($httph['Referer'])) echo '<b>Referer:</b> ' . $httph['Referer'] . '<br>';
            			?></td>
            		</tr>
            	</tbody>
            </table>
        </div>
        <h4>Browser informations:</h4>
        <table id="browser-table" class="table table-bordered table-selectable">
        	<tbody>
        		<tr>
        			<th scope="row">Browser</th>
        			<td id="browser">Unknown</td>
        		</tr>
        		<tr>
        			<th scope="row">Operating System</th>
        			<td id="os">Unknown</td>
        		</tr>
        		<tr>
        			<th scope="row">Screen size</th>
        			<td id="screen_size">Unknown</td>
        		</tr>
        		<tr>
        			<th scope="row">Window size</th>
        			<td id="window_size">Unknown</td>
        		</tr>
        		<tr>
            		<th scope="row">Cookies enabled</th>
            		<td id="cookies">Unknown</td>
        		</tr>
        		<tr>
            		<th scope="row">JavaScript enabled</th>
            		<td id="js_enabled" class="out-error">false</td>
        		</tr>
        		</tbody>
        	</table>
        	<p id="js_alert" class="out-error">*You must enable JavaScript on your browser to see these informations!</p>
        <?php echo $args['after_content'];
    }
}