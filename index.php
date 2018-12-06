<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

include_once 'config.php';
if(!$config['debug']){
   error_reporting(0);
}
$root = $config['root_url'] . '/';
define('WEBTOOLS', true);
include_once 'include/mainclass.php';
WebTools::init($config);
include_once 'include/scripts.php';
WebTools::callHooks('script_init');
$title = null;
if(!WebTools::isHome() && isset($_GET['page'])){
   WebTools::loadPage($title);
}
if(isset($_GET['error']) && $_GET['error'] == '404'){
   include_once 'include/404.php';
}
?>
<!DOCTYPE html>
<html style="height: 100%">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="/favicon.ico">
		<!-- jQuery -->
		<script src="include/js/jquery.min.js"></script>
		<!-- Include xWeb js -->
		<script src="include/js/xweb.min.js"></script>
		<!-- Include xWeb Stylesheet -->
		<link rel="stylesheet" href="include/css/xweb.min.css">
		<!-- Include Font-Awesome Stylesheet -->
		<link rel="stylesheet" href="include/css/font-awesome.min.css">
		<style type="text/css">
		  .panel-content {
		      overflow: auto;   
		  }
		</style>
		<?php
        	if($title){
        	    $title .= ' ' . WebTools::getTitleSeparator() . ' ' . WebTools::getName();
        	}else{
                $title = WebTools::getName();
        	}
            WebTools::callHooks('init_header');
            if(WebTools::hasHooks('init_title')){
              $title = WebTools::callHooks('init_title', array($title));
            }
		?>
		<title><?php echo $title;?></title>
	</head>
	<body style="position: relative; min-height: 100%; line-height: 1.6; background: <?php echo WebTools::getBackground();?>">
		<?php
		WebTools::callHooks('init_body');
		  include_once 'include/navbar.php';
		?>
		<div class="content" style="padding-bottom: 58px">
			<div class="col-8">
			<?php
				WebTools::callHooks('draw_main_panel_after');
				$mp_args = array(array(
				    'before_title' => '<div class="panel panel-default"><div class="panel-header"><h3 class="panel-title">',
				    'after_title' => '</h3></div><div class="panel-content">',
				    'after_content' => '</div></div>'
				));
				if(WebTools::isMySQLInitialized()){
    				if(WebTools::isHome()){
    				    include_once 'include/home.php';
    				    WebTools::addHook('draw_main_panel', 'drawHome');
    				}else if(!WebTools::isPageRegistered($_GET['page'])){
    				    include_once 'include/404.php';
    				}
    				WebTools::callHooks('draw_main_panel', $mp_args);
    				WebTools::callHooks('draw_main_panel_before');
    				WebTools::callHooks('draw_page_before');
				}else{?>
				    <div class="alert alert-error no-margins"><h4>Failed to connect to MySQL database!</h4><p><?php echo WebTools::getLastMySQLError();?></p></div><?php
				}?>
			</div>
			<div class="col-4">
				<div class="panel panel-primary-lt">
                    <div class="panel-header">
                        <h3 class="panel-title">Tools</h3>
                    </div>
        			<div class="panel-content">
        				<?php
        				$items = WebTools::getAllToolItems();
        				WebTools::callHooks('draw_tools_panel_list', array(&$items));
        				foreach($items as $k => $v){
        				    echo '<p><a href="' . $v['link'] . '">' . $k . "</a></p>";
        				}
        				?>
					</div>
				</div>
				<?php
				    WebTools::callHooks('draw_panels_dx_before');
				    WebTools::callHooks('draw_panels_dx');
				    WebTools::callHooks('draw_panels_dx_after');
				?>
			</div>
		</div>
		<?php include_once 'include/footer.php';
		  WebTools::callHooks('end_page');
		  if(WebTools::isMySQLInitialized()){
		      WebTools::getMySQL()->close();
		  }?>
	</body>
</html>