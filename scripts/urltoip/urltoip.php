<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once WebTools::getScriptPath(__FILE__) . 'config.php';
WebTools::addHook('script_init', array('URLToIP', 'init'));

class URLToIP {
    
    public static function init(){
        WebTools::addHook('init_navbar', array('URLToIP', 'initNavbar'));
        WebTools::addToolItem('URL To IP', '?page=url-to-ip', 20);
        WebTools::registerPage('url-to-ip', array('URLToIP', 'onPage'), 'URL To IP');
    }
    
    public static function onPage(){
        WebTools::addHook('draw_main_panel', array('URLToIP', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'URL To IP', '?page=url-to-ip', 20);
    }
    
    public static function drawMain($args){
        global $config;
        $apikey = $config['url-to-ip']['maps_api_key'];
        echo $args['before_title'] . 'URL To IP' . $args['after_title'];?>
        <p>Get the IP address linked to the specified URL.</p>
        <form method="post">
            <div class="input-group" style="display: flex">
                <input type="text" class="input" style="width: 100%" placeholder="Enter URL" name="url" id="url" value="<?php if(isset($_POST['url'])){ echo $_POST['url'];}?>">
                <button class="button button-primary" style="white-space: nowrap" type="submit">Get URL Info</button>
            </div>
        </form>
        <?php
        if(isset($_POST['url'])){
            if(trim($_POST['url']) != ''){
                $name = rtrim(preg_replace('#^https?://#', '', $_POST['url']), '/');
                $ip = gethostbyname($name);
                if(strcasecmp($ip, $name) != 0){
                    $loc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
                    $country = $loc['geoplugin_countryName'];
                    $region = $loc['geoplugin_regionName'];
                    $city = $loc['geoplugin_city'];
                    $latitude = $loc['geoplugin_latitude'];
                    $longitude = $loc['geoplugin_longitude'];
                    $isp = gethostbyaddr($ip);
                    ?>
                    <h4>Informations of <?php echo $name;?>:</h4>
                   	<table class="table table-bordered table-selectable">
                        <tbody>
                        <tr>
                            <th scope="row">IP</th>
                            <td><?php echo $ip;?></td>
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
                    <?php }
                }else{?>
                	<div class="alert alert-error no-margins"><h4>Invalid URL specified!</h4><p>The URL you specified is not vaild.</p></div><?php
                }
            }else{?>
                	<p class="out-error">Please enter a valid URL to continue.</p><?php
            }
        }
        echo $args['after_content'];
    }
}