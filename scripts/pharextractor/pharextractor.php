<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once WebTools::getScriptPath(__FILE__) . 'config.php';
WebTools::addHook('script_init', array('PharExtractor', 'init'));

class PharExtractor {
    
    const SUCCESS = 0;
    const ERR_UPLOAD = 1;
    const ERR_NOT_PHAR = 2;
    const ERR_TOO_BIG = 3;
    const ERR_PHARTOOLS = 4;
    
    public static function init(){
        WebTools::addHook('init_navbar', array('PharExtractor', 'initNavbar'));
        WebTools::addToolItem('Phar Extractor', '?page=phar-extractor', 30);
        WebTools::registerPage('phar-extractor', array('PharExtractor', 'onPage'), 'Phar Extractor');
    }
    
    public static function onPage(){
        WebTools::addHook('init_header', array('PharExtractor', 'initHeader'));
        WebTools::addHook('draw_main_panel', array('PharExtractor', 'drawMain'));
        Ratings::initRatings();
    }
    
    public static function initHeader(){
        echo '<script src="scripts/pharextractor/script.js"></script>';
    }
    
    public static function initNavbar(){
        if(!WebTools::getNavItem('Tools')){
            WebTools::createNavItem('Tools');
        }
        WebTools::addNavSubItem('Tools', 'Phar Extractor', '?page=phar-extractor', 30);
    }
    
    public static function drawMain($args){
        echo $args['before_title'] . 'Phar Extractor' . $args['after_title'];?>
        <p>Easily extract *.phar files. The tool is based on <a href="https://www.evolsoft.tk/phartools" target="_blank">PharTools</a> script.</p><?php
        if(isset($_FILES['finput'])){
            self::drawFileForm();
        }else{
            self::drawQueryForm();
        }
        echo $args['after_content'];
    }
    
    private static function uploadFile($ffield, &$resname){
        global $config;
        include_once WebTools::getScriptPath(__FILE__) . 'phartools.php';
        $tmp_dir = WebTools::getScriptPath(__FILE__) . $config['pharextractor']['temp_folder'];
        $data_dir = WebTools::getScriptPath(__FILE__) . $config['pharextractor']['data_folder'];
        $cache_time = $config['pharextractor']['cache_time'];
        $max_upload = $config['pharextractor']['max_upload'];
        if($max_upload > 0){
            $max_upload = min($max_upload * 1048576, (int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
        }else{
            $max_upload = min((int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
        }
        $fname = pathinfo(basename($_FILES[$ffield]['name']), PATHINFO_FILENAME);
        $fext = strtolower(pathinfo(basename($_FILES[$ffield]['name']), PATHINFO_EXTENSION));
        if(strcasecmp($fext, "phar") != 0){
            return self::ERR_NOT_PHAR;
        }
        if($_FILES[$ffield]['error'] == UPLOAD_ERR_FORM_SIZE || $_FILES[$ffield]['error'] == UPLOAD_ERR_INI_SIZE || ($max_upload > 0 && $_FILES[$ffield]['size'] > $max_upload)){
            return self::ERR_TOO_BIG;
        }
        if(!is_uploaded_file($_FILES[$ffield]['tmp_name'])){
            return self::ERR_UPLOAD;
        }
        if(!file_exists($tmp_dir)){
            @mkdir($tmp_dir);
        }
        if(!file_exists($data_dir)){
            @mkdir($data_dir);
        }
        if($cache_time > 0){
            $time = time();
            foreach(scandir($data_dir) as $cfile){
                if(!is_dir($data_dir . $cfile)){
                    $cfiletime = filemtime($data_dir . $cfile);
                    if($time - $cfiletime > 60){
                        @unlink($data_dir . $cfile);
                    }
                }
            }
        }
        $uid = self::generateRandomString(5);
        while(file_exists($tmp_dir . $fname . '-' . $uid . '.' . $fext)){
            $uid = self::generateRandomString(5);
        }
        $fname .= '-' . $uid;
        $target = $fname . '.' . $fext;
        if(move_uploaded_file($_FILES[$ffield]['tmp_name'], $tmp_dir . $target)){
            $status = null;
            if(isset($_POST['output']) && strcasecmp($_POST['output'], 'tar') == 0){
                $ext = '.tar';
                $status = PharTools::ToArchive($tmp_dir . $target, Phar::TAR);
            }else{
                $ext = '.zip';
                $status = PharTools::ToArchive($tmp_dir . $target, Phar::ZIP);
            }
            rename($tmp_dir . $fname . $ext, $data_dir . $fname . $ext);
            unset($phar);
            @unlink($tmp_dir . $target);
            $resname = $fname . $ext;
            return ($status == PharTools::SUCCESS) ? self::SUCCESS : self::ERR_PHARTOOLS;
        }
        return self::ERR_UPLOAD;
    }
    
    private static function drawFileForm(){
        global $config;
        $resname = null;
        $res = self::uploadFile('finput', $resname);
        if($res == self::SUCCESS){
            $data_dir = WebTools::getScriptPath(__FILE__) . $config['pharextractor']['data_folder'];
            if(file_exists($data_dir . $resname)){?>
            	<div class="box">
    				<h2><?php echo $resname;?></h2>
        			<p><b>Format: </b><?php 
        			$ext = strtolower(pathinfo($resname, PATHINFO_EXTENSION));
        			if(strcasecmp($ext, 'tar') == 0){
        			    echo 'TAR Archive (*.tar)';
        			}else{
        			    echo 'ZIP Archive (*.zip)';
        			}?>
        			<br>
        			<b>Size: </b><?php echo self::formatSize(filesize($data_dir . $resname));?></p>
					<br>
					<a class="button full-width" style="text-align: center" href="<?php echo WebTools::getRootURL() . $data_dir . $resname?>"><span class="fa fa-download"></span> Download</a>
    				<br>
				</div>
				<p class="out-error">*The file will be cached for a maximum of one minute. After that the file will be deleted from our servers!</p><?php
            }else{?>
                <div class="alert alert-error no-margins"><h4>File not found!</h4><p>The file you are trying to download does not exist or it has been deleted.</p></div><?php
            }
        }else if($res == self::ERR_UPLOAD){?>
        	<div class="alert alert-error no-margins"><h4>File upload failed!</h4><p>An error has occurred while uploading the file. Please try again.</p></div><?php
        }else if($res == self::ERR_NOT_PHAR){?>
            <div class="alert alert-error no-margins"><h4>Invalid phar archive!</h4><p>The file you are trying to upload is not a valid phar archive.</p></div><?php
        }else if($res == self::ERR_TOO_BIG){
            $max_upload = $config['pharextractor']['max_upload'];
            if($max_upload > 0){
                $max_upload = min($max_upload * 1048576, (int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
            }else{
                $max_upload = min((int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
            }?>
            <div class="alert alert-error no-margins"><h4>File too big!</h4><p>The phar archive you are trying too upload is too big. The maximum allowed phar archive size is <?php echo self::formatSize($max_upload)?></p></div><?php
        }else if($res == self::ERR_PHARTOOLS){?>
            <div class="alert alert-error no-margins"><h4>PharTools error!</h4><p>An error has occurred while extracting the file. Please try again.</p></div><?php
        }
    }
    
    private static function drawQueryForm(){ 
        global $config;
        $max_upload = $config['pharextractor']['max_upload'];
        if($max_upload > 0){
            $max_upload = min($max_upload * 1048576, (int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
        }else{
            $max_upload = min((int)(ini_get('upload_max_filesize')) * 1048576, (int)(ini_get('post_max_size')) * 1048576, (int)(ini_get('memory_limit')) * 1048576);
        }
        ?>
        <form action="?page=phar-extractor" method="post" enctype="multipart/form-data">
            <div class="input-group" style="display: flex">
                <input type="file" class="input" style="width: 100%" id="finput" name="finput">
                <button class="button button-primary" style="white-space: nowrap" type="submit">Extract!</button>
            </div>
            <p class="out-gray">Max upload size: <?php echo self::formatSize($max_upload);?></p>
            <h4>Parameters:</h4>
            <div class="row">
            	<div class="col-2"><p>Output format:</p></div>
            	<div class="col-2"><input type="radio" name="output" id="output" value="zip" checked> .zip</div>
            	<div class="col-2"><input type="radio" name="output" id="output" value="tar"> .tar</div>
            </div>
            <div id="cmd"></div>
            <p class="out-error">*The file will be cached for a maximum of one minute. After that the file will be deleted from our servers!</p>
        </form>
    <?php }
    
    private static function generateRandomString($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    /**
     * Format size
     *
     * @param float $bytes
     *
     * @return string
     */
    private static function formatSize($bytes){
        if($bytes >= 1073741824){
            $bytes = rtrim(rtrim(number_format($bytes / 1073741824), '0'), ',') . ' GB';
        }else if($bytes >= 1048576){
            $bytes = rtrim(rtrim(number_format($bytes / 1048576, 2, ',', '.'), '0'), ',') . ' MB';
        }else if($bytes >= 1024){
            $bytes = rtrim(rtrim(number_format($bytes / 1024, 2, ',', '.'), '0'), ',') . ' KB';
        }else{
            $bytes = number_format($bytes, 0, ',', '.') . ' bytes';
        }
        return $bytes;
    }
}