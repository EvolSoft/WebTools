<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::addHook('script_init', array('DonateScript', 'init'));

class DonateScript {
    
    public static function init(){
        WebTools::addHook('draw_panels_dx_after', array('DonateScript', 'drawPanel'));
    }
    
    public static function drawPanel(){?>
        <div class="panel panel-success-lt">
            <div class="panel-header">
                <h3 class="panel-title">Donate</h3>
            </div>
            <div class="panel-content">
                <center>
                    If you want you can support this project with a small donation. Your generosity will help us paying web hosting, domains, buying programs (such as IDEs, debuggers, etc...) and new hardware to improve software development.<br>Thank you <span class="fa fa-smile-o fa-lg out-warning"></span><br><br>
            		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="EX7RB3X8VMVJG">
                        <input type="image" src="https://www.paypalobjects.com/en_US/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                    </form>
            	</center>
            </div>
        </div><?php
    }
}