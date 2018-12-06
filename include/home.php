<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');

function drawHome($args){
    echo $args['before_title'] . WebTools::getHomePanelTitle() . $args['after_title'] . WebTools::getHomePanelText() . $args['after_content'];
}