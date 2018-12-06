<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
WebTools::registerPage('ratings', array('Ratings', 'doRating'));

class Ratings {

    const SUCCESS = 0;
    const ERR_GENERIC = 1;
    const ERR_MYSQL = 2;
    const ERR_INVALID_INPUT = 3;
    const ERR_ALREADY_VOTED = 4;
    
    /**
     * @internal
     */
    public static function doRating(){
        if(isset($_POST['rating_id']) && isset($_POST['rating_rating'])){
            $json = array(
                'status' => self::ERR_GENERIC,
                'tot_ratings' => 0,
                'average' => 0
            );
            $id = $_POST['rating_id'];
            $rating = $_POST['rating_rating'];
            if(!is_numeric($rating)){
                $json['error'] = self::ERR_INVALID_INPUT;
                die(json_encode($json));
            }
            $rating = intval($rating);
            if($rating < 1 || $rating > 5 || !WebTools::isPageRegistered($id)){
                $json['status'] = self::ERR_INVALID_INPUT;
                die(json_encode($json));
            }
            if(WebTools::isMySQLInitialized()){
                $res = WebTools::getMySQL()->query('SELECT * FROM ' . WebTools::getMySQLTablePrefix() . 'ratings WHERE id=\''. $id . '\'');
                $json['status'] = self::SUCCESS;
                while($row = $res->fetch_assoc()){
                    if($_SERVER['REMOTE_ADDR'] == $row['ip']){
                        $json['status'] = self::ERR_ALREADY_VOTED;
                        die(json_encode($json));
                    }
                    $json['tot_ratings'] += 1;
                    $json['average'] += $row['rating'];
                }
                $json['tot_ratings']++; //The pending rating
                $json['average'] += $rating; //The pending rating
                $json['average'] /= $json['tot_ratings'];
                if(!WebTools::getMySQL()->query('INSERT INTO ' . WebTools::getMySQLTablePrefix() . 'ratings (id, ip, rating) VALUES (\'' . $id . '\', \'' . $_SERVER['REMOTE_ADDR'] . '\', \'' . $rating . '\')')){
                    $json['status'] = self::ERR_MYSQL;
                }
                die(json_encode($json));
            }
            $json['status'] = self::ERR_MYSQL;
            die(json_encode($json));
        }
        header('Location: ' . WebTools::getRootURL());
    }
    
    /**
     * Initialize rating system for the current script
     */
    public static function initRatings(){
        WebTools::addHook('draw_main_panel_before', array('Ratings', 'drawRatings'));
        WebTools::addHook('init_header', array('Ratings', 'initHeader'));
    }
    
    /**
     * @internal
     */
    public static function initHeader(){
        echo '<script src="include/js/ratings.js"></script>';
    }
    
    /**
     * @internal
     */
    private static function getRatings(){
        $ret = array(0, 0);
        if(WebTools::isMySQLInitialized()){
            $res = WebTools::getMySQL()->query('SELECT * FROM ' . WebTools::getMySQLTablePrefix() . 'ratings WHERE id=\''. $_GET['page'] . '\'');
            if($res->num_rows > 0){
                $ret[0] = $res->num_rows;
                while($row = $res->fetch_assoc()){
                    $ret[1] += $row['rating'];
                }
                $ret[1] /= $ret[0];
            }
        }
        return $ret;
    }
    
    /**
     * @internal
     */
    public static function drawRatings(){
        $ratings = self::getRatings();?>
    	<h3><span class="fa fa-star"></span> Ratings:</h3>
    	<div id="ratings" style="user-select: none">
    		<div id="stars" style="display: inline-block; color: #f0ba14; cursor: pointer">
    			<?php
    			$ratings[1] = round($ratings[1], 1);
    			for($i = 1; $i <= floor($ratings[1]); $i++){
    			    echo '<span name="' . $i .'" class="fa fa-star fa-lg"></span>';
    			}
    			if($ratings[1] - floor($ratings[1]) > 0){
    			    echo '<span name="' . $i .'" class="fa fa-star-half-o fa-lg"></span>';
    			    $i++;
    			}
    			for($l = $i; $l <= 5; $l++){
    			    echo '<span name="' . $l .'" class="fa fa-star-o fa-lg"></span>';
    			}
    		    ?>
        	</div>
        	<br>
        	<?php 
        	if($ratings[0]){?>
        	<p id='ratings_text' class="out-gray" style="user-select: text"><?php echo '<b>' . $ratings[1] . '</b>/5 stars (' . $ratings[0] . ($ratings[0] == 1 ? ' vote' : ' votes');?>)</p>
    		<?php }else{?>
    		<p id='ratings_text' class="out-gray" style="user-select: text">This script has not been rated yet.</p>
    		<?php }?>
    	</div>
    	<?php
    }
}