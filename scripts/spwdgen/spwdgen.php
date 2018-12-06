<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::addHook('script_init', array('SimplePasswordGenerator', 'init'));

class SimplePasswordGenerator {
    
    public static function init(){
        WebTools::addHook('init_navbar', array('SimplePasswordGenerator', 'initNavbar'));
        WebTools::addToolItem('Simple Password Generator', '?page=spwdgen', 40);
        WebTools::registerPage('spwdgen', array('SimplePasswordGenerator', 'onPage'), 'Simple Password Generator');
    }
    
    public static function onPage(){
        WebTools::addHook('init_header', array('SimplePasswordGenerator', 'initHeader'));
        WebTools::addHook('draw_main_panel', array('SimplePasswordGenerator', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initHeader(){
        echo '<script src="scripts/spwdgen/script.js"></script>';
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'Simple Password Generator', '?page=spwdgen', 40);
    }
    
    public static function drawMain($args){
        echo $args['before_title'] . 'Simple Password Generator' . $args['after_title'];?>
        <p>Generate random secure passwords from 8 to 16 characters long.</p>
        <form method="post">
        	<?php
        	   $_POST['password'] = self::generateRandomString(rand(8, 16));
        	?>
            <div class="input-group" style="display: flex">
                <input type="text" class="input" style="width: 100%" name="password" id="password" value="<?php echo $_POST['password'];?>">
                <button class="button button-primary" style="white-space: nowrap" type="submit">Generate Password</button>
            </div>
        </form>
    <?php
        echo $args['after_content'];
    }
    
    private static function generateRandomString($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

