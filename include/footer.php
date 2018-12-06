<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!'); 
function footer_getviews(){
    if(WebTools::isMySQLInitialized()){
        $db = WebTools::getMySQL();
        $res = $db->query('SELECT * FROM ' . WebTools::getMySQLTablePrefix() . 'views LIMIT 1');
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            if(isset($_GET['nc'])){
                return $row['count']; 
            }
            $i = $row['count'] + 1;
            if($db->query('UPDATE ' . WebTools::getMySQLTablePrefix() . 'views SET count=' . $i . ' WHERE 1')){
                return $i;
            }
        }
    }
    return 'Unknown';
}
?>
<div class="footer" style="bottom: 0; height: 58px">
    <div class="content">
    	<div class="col-6">
    		<p style="margin: 0; text-align: left">&copy; <?php echo date('Y');?> <a href="https://www.evolsoft.tk" target="_blank">EvolSoft</a></p>
    	</div>
    	<div class="col-6">
    		<p style="margin: 0; text-align: right">Views: <?php echo footer_getviews();?></p>
    	</div>
    </div>
</div>