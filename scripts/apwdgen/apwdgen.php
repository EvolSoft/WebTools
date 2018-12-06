<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::addHook('script_init', array('AdvancedPasswordGenerator', 'init'));

class AdvancedPasswordGenerator {
    
    public static function init(){
        WebTools::addHook('init_navbar', array('AdvancedPasswordGenerator', 'initNavbar'));
        WebTools::addToolItem('Advanced Password Generator', '?page=apwdgen', 50);
        WebTools::registerPage('apwdgen', array('AdvancedPasswordGenerator', 'onPage'), 'Advanced Password Generator');
    }
    
    public static function onPage(){
        WebTools::addHook('init_header', array('AdvancedPasswordGenerator', 'initHeader'));
        WebTools::addHook('draw_main_panel', array('AdvancedPasswordGenerator', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initHeader(){
        echo '<script src="scripts/apwdgen/script.js"></script>';
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'Advanced Password Generator', '?page=apwdgen', 50);
    }
    
    public static function drawMain($args){
        echo $args['before_title'] . 'Advanced Password Generator' . $args['after_title'];?>
        <p>Generate customized random secure passwords.</p>
        <form method="post">
        	<?php
        	    isset($_POST['plen']) && $_POST['plen'] != '' ? $plen = $_POST['plen'] : $plen = 8;
                isset($_POST['in']) ? $in = $_POST['in'] : $in = 0;
                isset($_POST['ip']) ? $ip = $_POST['ip'] : $ip = 0;
                isset($_POST['imc']) ? $imc = $_POST['imc'] : $imc = 0;
                if($plen < 4 || $plen > 64){
                    $_POST['password'] = self::generateRandomString(8, $in, $ip, $imc);
                }else{
                    $_POST['password'] = self::generateRandomString($plen, $in, $ip, $imc);
                }
        	?>
            <div class="input-group" style="display: flex">
                <input type="text" class="input" style="width: 100%" name="password" id="password" value="<?php echo $_POST['password'];?>">
                <button class="button button-primary" style="white-space: nowrap" type="submit">Generate Password</button>
            </div>
            <h4>Parameters:</h4>
            <div class="form">
                <div class="col-2 ns">
                    <label class="" style="padding: 6px 0; display: block;">Password length:</label>
                </div>
                <div class="col-2">
                	<?php 
                	if($plen >= 4 && $plen <= 64){
                	    echo '<input type="text" class="input" name="plen" id="plen" placeholder="8" value="' . $plen .'"></div></div>';
                    }else{
                        echo '<input type="text" class="input input-error" name="plen" id="plen" placeholder="8" value="' . $plen .'"></div>';
                        echo '<br><br><br><p class="out-error" style="white-space: nowrap">Password length must be between 4 and 64</p></div>';
                    }?>
            <input type="checkbox" id="in" name="in" value="1" <?php if($in) echo 'checked="checked"'; ?>> Include numbers
            <br>
            <p>
            </p>
            <input type="checkbox" id="ip" name="ip" value="1" <?php if($ip) echo 'checked="checked"';?>> Include punctuation
            <br>
            <p>
            </p>
            <input type="checkbox" id="imc" name="imc" value="1" <?php if($imc) echo 'checked="checked"';?>> Include mixed case
        </form>
    <?php
        echo $args['after_content'];
    }
    
    private static function generateRandomString($length, $in, $ip, $imc){
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        if($in){
            $characters .= '0123456789';
        }
        if($ip){
            $characters .= '\!$%&/()=?<>{[*+}]@#;,:.-_';
        }
        if($imc){
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}