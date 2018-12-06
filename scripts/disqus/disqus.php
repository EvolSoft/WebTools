<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once WebTools::getScriptPath(__FILE__) . 'config.php';
WebTools::addHook('script_init', array('Disqus', 'init'));

class Disqus {
    
    public static function init(){
        global $config;
        if($config['disqus']['show_home']){
            WebTools::addHook('draw_page_before', array('Disqus', 'drawComments'));
        }else if(!WebTools::isHome()){
            WebTools::addHook('draw_page_before', array('Disqus', 'drawComments'));
        }
    }
    
    public static function drawComments(){
        global $config;
        $page = 'home';
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            if(!WebTools::isPageRegistered($_GET['page']) || in_array($_GET['page'], $config['disqus']['disabled']) || strcasecmp($_GET['page'], 'ratings') == 0){
                return;
            }
        }?>
    	<h3><span class="fa fa-comments"></span> Comments:</h3>
    	<div id="disqus_thread"></div>
        <script>
            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
             */
            var disqus_config = function () {
                this.page.url = '<?php echo(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>';  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = '<?php echo $page;?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
                var d = document, s = d.createElement('script');
                
                s.src = 'https://<?php echo $config['disqus']['url'];?>/embed.js';  // IMPORTANT: Replace EXAMPLE with your forum shortname!
                
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript><br><?php
    }
}