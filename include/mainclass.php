<?php

/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

defined('WEBTOOLS') or die('This script can\'t be called directly!');
include_once 'ratings.php';

class WebTools {
    
    /** @var array */    
    private static $navitems = array();
    
    /** @var array */
    private static $toolitems = array();
    
    /** @var array */
    private static $hooks = array();
    
    /** @var array */
    private static $pages = array();
    
    /** @var bool */
    private static $init = false;
    
    /** @var array */
    private static $config = array();
    
    /** @var string */
    private static $rootpath;
    
    /** @var mysqli */
    private static $db;
    
    /**
     * @internal 
     * 
     * Initialize WebTools instance
     * 
     * @param array $config
     */
    public static function init($config){
        if(!self::$init){
            self::$init = true;
            isset($config['root_url']) ? self::$config['root_url'] = self::addTrailingSlash($config['root_url'], '/') : self::$config['root_url'] = 'http://localhost/';
            isset($config['title_separator']) ? self::$config['title_separator'] = $config['title_separator'] : self::$config['title_separator'] = '-';
            isset($config['background']) ? self::$config['background'] = $config['background'] : self::$config['background'] = '#fcfcfc';
            isset($config['home_title']) ? self::$config['home_title'] = $config['home_title'] : self::$config['home_title'] = 'Welcome to WebTools';
            isset($config['home_text']) ? self::$config['home_text'] = $config['home_text'] : self::$config['home_text'] = 'You can customize this text from <i>config.php</i> file.';
            isset($config['mysql_host']) ? self::$config['mysql_host'] = $config['mysql_host'] : self::$config['mysql_host'] = '';
            isset($config['mysql_port']) ? self::$config['mysql_port'] = $config['mysql_port'] : self::$config['mysql_port'] = 3306;
            isset($config['mysql_user']) ? self::$config['mysql_user'] = $config['mysql_user'] : self::$config['mysql_user'] = '';
            isset($config['mysql_password']) ? self::$config['mysql_password'] = $config['mysql_password'] : self::$config['mysql_password'] = '';
            isset($config['mysql_database']) ? self::$config['mysql_database'] = $config['mysql_database'] : self::$config['mysql_database'] = '';
            isset($config['mysql_table_prefix']) ? self::$config['mysql_table_prefix'] = $config['mysql_table_prefix'] : self::$config['mysql_table_prefix'] = 'webtools_';
            self::$rootpath = getcwd();
            self::initMySQL();
        }
    }
    
    /**
     * @internal
     * 
     * Initalize MySQL connection
     */
    private static function initMySQL(){
        $host = self::$config['mysql_host'];
        $port = self::$config['mysql_port'];
        $user = self::$config['mysql_user'];
        $pwd = self::$config['mysql_password'];
        $db = self::$config['mysql_database'];
        $prefix = self::$config['mysql_table_prefix'];
        self::$db = new mysqli($host, $user, $pwd, null, $port);
        if(!self::$db->select_db($db)){
            if(self::$db->query('CREATE DATABASE ' . $db)) return;
            self::$db->select_db($db);
        }
        if(!self::$db->query('CREATE TABLE IF NOT EXISTS ' . $prefix . 'views (count BIGINT(1))')) return;
        $res = self::$db->query('SELECT * FROM ' . $prefix . 'views LIMIT 1');
        if($res->num_rows == 0){
            if(!self::$db->query('INSERT INTO ' . $prefix . 'views (count) VALUES (0)')) return;
        }
        if(!self::$db->query('CREATE TABLE IF NOT EXISTS ' . $prefix . 'ratings (id VARCHAR(16), ip VARCHAR(16), rating TINYINT(1))')) return;
    }
    
    /**
     * Get MySQL table prefix
     * 
     * @return string
     */
    public static function getMySQLTablePrefix(){
        return self::$config['mysql_table_prefix'];
    }
    
    /**
     * Get MySQL instance
     *
     * @return mysqli
     */
    public static function getMySQL(){
        return self::$db;
    }
    
    /**
     * Get last MySQL error
     * 
     * @return string
     */
    public static function getLastMySQLError(){
        return self::$db->connect_error;
    }
    
    /**
     * Check if MySQL is initalized
     * 
     * @return bool
     */
    public static function isMySQLInitialized(){
        return self::getLastMySQLError() ? false : true;
    }
    
    /**
     * Get WebTools version
     * 
     * @return string
     */
    public static function getVersion(){
        return '1.0.0';
    }
    
    /**
     * Get root URL
     * 
     * @return string|null
     */
    public static function getRootURL(){
        if(self::$init){
            return self::$config['root_url'];
        }
        return null;
    }
    
    /**
     * Get root path
     *
     * @return string|null
     */
    public static function getRootPath(){
        if(self::$init){
            return self::addTrailingSlash(self::$rootpath, DIRECTORY_SEPARATOR);
        }
        return null;
    }
    
    /**
     * Get title separator
     *
     * @return string|null
     */
    public static function getTitleSeparator(){
        if(self::$init){
            return self::$config['title_separator'];
        }
        return null;
    }
    
    /**
     * Get background
     *
     * @return string|null
     */
    public static function getBackground(){
        if(self::$init){
            return self::$config['background'];
        }
        return null;
    }
    
    
    /**
     * Get name
     *
     * @return string
     */
    public static function getName(){
        return 'WebTools';
    }
    
    /**
     * Check if current page is homepage
     * 
     * @return bool
     */
    public static function isHome(){
        return !isset($_GET['page']);
    }
    
    /**
     * Get home panel title
     *
     * @return string|null
     */
    public static function getHomePanelTitle(){
        if(self::$init){
            return self::$config['home_title'];
        }
        return null;
    }
    
    /**
     * Get home panel text
     *
     * @return string|null
     */
    public static function getHomePanelText(){
        if(self::$init){
            return self::$config['home_text'];
        }
        return null;
    }
    
    /**
     * @internal
     * 
     * Add trailing slash to the specified string
     * 
     * @param string $str
     * @param string $slash
     * 
     * @return string
     */
    public static function addTrailingSlash($str, $slash){
        if($str[strlen($str) - 1] != $slash){
            $str .= $slash;
        }
        return $str;
    }
    
    /**
     * Get script path
     * 
     * @param string $file
     * 
     * @return string
     */
    public static function getScriptPath($file){
        return self::addTrailingSlash(substr(dirname($file), strlen(self::getRootPath())), DIRECTORY_SEPARATOR);
    }
    
    /**
     * Get absolute script path
     *
     * @param string $file
     *
     * @return string
     */
    public static function getAbsScriptPath($file){
        return self::addTrailingSlash(dirname($file), DIRECTORY_SEPARATOR);
    }
    
    /**
     * Create navigation item
     * 
     * @param string $name
     * @param string $link
     * @param int $pos
     */
    public static function createNavItem($name, $link = null, $pos = null){
        if($link){
            self::$navitems[$name]['link'] = $link;
        }
        if($pos){
            self::$navitems[$name]['pos'] = $pos;
        }
        self::$navitems[$name]['sub_items'] = array();
    }
    
    /**
     * Get navigation item
     * 
     * @param string $name
     * 
     * @return array|null
     */
    public static function getNavItem($name){
        if(isset(self::$navitems[$name])){
            return self::$navitems[$name];
        }
        return null;
    }
    
    /**
     * Remove navigation item
     * 
     * @param string $name
     */
    public static function removeNavItem($name){
        if(isset(self::$navitems[$name])){
            unset(self::$navitems[$name]);
        }
    }
    
    /**
     * Add navigation subitem
     * 
     * @param string $navitem
     * @param string $name
     * @param string $link
     * @param int $pos
     */
    public static function addNavSubItem($navitem, $name, $link, $pos = null){
        if(isset(self::$navitems[$navitem])){
            $sub = array('name' => $name, 'link' => $link);
            if($pos){
                $sub['pos'] = $pos;
            }
            array_push(self::$navitems[$navitem]['sub_items'], $sub);
        }
    }
    
    /**
     * Get all navigation items
     * 
     * @return array
     */
    public static function getAllNavItems(){
        uasort(self::$navitems, array('WebTools', 'cmp'));
        return self::$navitems;
    }
    
    /**
     * Get all navigation subitems
     * 
     * @param string $navitem
     * 
     * @return array|null
     */
    public static function getAllNavSubItems($navitem){
        if(isset(self::$navitems[$navitem])){
            uasort(self::$navitems[$navitem]['sub_items'], array('WebTools', 'cmp'));
            return self::$navitems[$navitem]['sub_items'];
        }
        return null;
    }
    
    /**
     * Add an item to the tool panel
     * 
     * @param string $name
     * @param string $link
     * @param int $pos
     */
    public static function addToolItem($name, $link, $pos = null){
        if(!isset(self::$toolitems[$name])){
            self::$toolitems[$name]['link'] = $link;
            if($pos){
                self::$toolitems[$name]['pos'] = $pos;
            }
        }
    }
    
    /**
     * Remove item from the tool panel
     * 
     * @param string $name
     */
    public static function removeToolItem($name){
        if(isset(self::$toolitems[$name])){
            unset(self::$toolitems[$name]);
        }
    }
    
    /**
     * Get all items in the tool panel
     * 
     * @return array
     */
    public static function getAllToolItems(){
        uasort(self::$toolitems, array('WebTools', 'cmp'));
        return self::$toolitems;
    }
    
    /**
     * @internal
     * 
     * @param array $a
     * @param array $b
     * 
     * @return number
     */
    private static function cmp($a, $b){
        if(!isset($a['pos'])){
            $a = 0;
        }else{
            $a = $a['pos'];
        }
        if(!isset($b['pos'])){
            $b = 0;
        }else{
            $b = $b['pos'];
        }
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
    
    /**
     * Add hook
     * 
     * @param string $hook
     * @param callable $fnc
     */
    public static function addHook($hook, $fnc){
        if(isset(self::$hooks[$hook])){
            array_push(self::$hooks[$hook], $fnc);
            return;
        }
        self::$hooks[$hook][0] = $fnc;
    }
    
    /**
     * Check if the specified hook has callables
     * 
     * @param string $hook
     * 
     * @return bool
     */
    public static function hasHooks($hook){
        return isset(self::$hooks[$hook]);
    }
    
    /**
     * Call hooks
     * 
     * @param string $hook
     * @param array $args
     * 
     * @return mixed|null
     */
    public static function callHooks($hook, array $args = null){
        $vres = null;
        if(isset(self::$hooks[$hook])){
            foreach(self::$hooks[$hook] as $fnc){
                if($args){
                    $res = call_user_func_array($fnc, $args);
                    if($res){
                        $vres = $res;
                    }
                }else{
                    $res = call_user_func($fnc);
                    if($res){
                        $vres = $res;
                    }
                }
            }
            return $vres;
        }
        return null;
    }
    
    /**
     * Register page
     * 
     * @param string $page
     * @param string $hook
     * @param string $title
     * 
     * @return bool
     */
    public static function registerPage($page, $hook, $title = null){
        $page = strtolower($page);
        if(preg_match('/[^a-z0-9\-_]/', $page)){
            return false;
        }
        if(!self::isPageRegistered($page)){
            self::$pages[$page][0] = $hook;
            self::$pages[$page][1] = $title;
            return true;
        }
        return false;
    }
    
    /**
     * Check if the specified page is registered
     * 
     * @param string $page
     * 
     * @return bool
     */
    public static function isPageRegistered($page){
        $page = strtolower($page);
        return isset(self::$pages[$page]);
    }
    
    /**
     * Unregister the specified page
     * 
     * @param string $page
     * 
     * @return bool
     */
    public static function unregisterPage($page){
        $page = strtolower($page);
        if(self::isPageRegistered($page)){
            unset(self::$pages[$page]);
            return true;
        }
        return false;
    }
    
    /**
     * @internal
     * 
     * Load page
     * 
     * @param string $title
     * 
     * @return bool
     */
    public static function loadPage(&$title = null){
        if(!isset($_GET['page'])){
            return false;
        }
        $page = strtolower($_GET['page']);
        if(self::isPageRegistered($page)){
            call_user_func(self::$pages[$page][0]);
            $title = self::$pages[$page][1];
            return true;
        }
        return false;
    }
    
    /**
     * Get page title
     * 
     * @param string $page
     * 
     * @return string|null
     */
    public function getPageTitle($page){
        $page = strtolower($page);
        if(self::isPageRegistered($page)){
            return self::$pages[$page][1];
        }
        return null;
    }
}