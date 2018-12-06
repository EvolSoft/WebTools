<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');

WebTools::addHook('draw_main_panel', 'draw404Error');

function draw404Error(){?>
    <div class="alert alert-error no-margins"><h4>404 Page not found!</h4><p>The requested page was not found. <a href="<?php echo WebTools::getRootURL();?>">Go to the homepage.</a></p></div><?php
}