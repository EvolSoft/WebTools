<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once 'include/mainclass.php';
?>
<nav class="navbar navbar-dark navbar-static">
	<a class="navbar-title" href="<?php echo WebTools::getRootURL();?>">WebTools</a>
	<button type="button" class="navbar-toggle"></button>
	<ul class="navbar-links">
		<?php
		WebTools::createNavItem('Home', WebTools::getRootURL());
		WebTools::callHooks('init_navbar_before');
		WebTools::callHooks('init_navbar');
		WebTools::callHooks('init_navbar_after');
		foreach(WebTools::getAllNavitems() as $k => $v){
		    $subs = WebTools::getAllNavSubItems($k);
		    if(count($subs) == 0){
		        echo '<li><a' . ($v['link'] ? ' href="' . $v['link'] . '"' : '') . '>' . $k . '</a></li>';
		    }else{
		        echo '<li class="menu-group"><a openmenu>' . $k . ' <span class="fa fa-caret-down"></span></a><ul class="menu" style="min-width: 250px">';
		        foreach($subs as $sub){
		            echo '<li><a' . ($sub['link'] ? ' href="' . $sub['link'] . '"' : '') . '>' . $sub['name'] . '</a></li>';
		        }
		        echo '</ul>';
		    }
		}
		?>
	</ul>
</nav>