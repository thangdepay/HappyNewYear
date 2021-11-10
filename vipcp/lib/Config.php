<?php
/**
 * 
 * This software is distributed under the GNU GPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2012 http://wapinet.ru
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.8.1 beta
 * 
 * PHP version >= 5.2.3
 * 
 */


class Config
{
    const SYNTAX_LOCALHOST          = 1;
    const SYNTAX_WAPINET            = 2;
    const REALNAME_RELATIVE         = 1;
    const REALNAME_FULL             = 2;
    const REALNAME_RELATIVE_HIDE    = 3;

    /**
     * @var Config_Interface
     */
    private static $_config;


    /**
     * setConfig
     * 
     * @param string $config
     */
    public static function setConfig ($config)
    {
        self::$_config = new Config_Ini($config);

        Registry::set('top', '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi">
		<head><title>Quản lí - Gmanager 0.8.1 beta</title>
		<meta http-equiv="Content-Type" content="' . self::getContentType() . '; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="vtr/style.css"/>
		<script type="text/javascript" src="js.js"></script>
		<script type="text/javascript" src="data/js.source.js"></script></head><body>
		<div class="header" align="center"><a href="index.php"><h1>LPanel 2.1</h1></a>
		<p align="left"><img src="vtr/img/pma.png" alt=""/> <a href="pma/">P.M.A</a> |
		<img src="vtr/icon/SQL.png" alt=""/> <a href="pma/saoluu.php">S.Lưu</a> | 
		<img src="vtr/img/cpanel.png" alt=""/> <a href="index.php?set">C.đặt</a> | 
		<img src="vtr/img/exit.png" alt=""/>  <a href="index.php?exit">Thoát</a></p></div>
		');
        Registry::set('foot', '<div class="header" align="center">
		<div align="left">
		<img src="vtr/img/pma.png" alt=""/> <a href="pma/">P.M.A</a> |
		<img src="vtr/icon/SQL.png" alt=""/> <a href="pma/saoluu.php">S.Lưu</a> | 
		<img src="vtr/img/cpanel.png" alt=""/> <a href="index.php?set">C.đặt</a> | 
		<img src="vtr/img/exit.png" alt=""/>  <a href="index.php?exit">Thoát</a>
		</div>
		<h2><a href="index.php?info">V2.1 - Tmc</a></h2>
		</div></body></html>');

        Language::setLanguage(self::get('Gmanager', 'language'));

        define('PCLZIP_TEMPORARY_DIR', self::getTemp() . '/');
        define('GMANAGER_REQUEST_TIME', time());

        mb_internal_encoding('UTF-8');
        setlocale(LC_ALL, self::get('PHP', 'locale'));
        date_default_timezone_set(self::get('PHP', 'timeZone'));
        @set_time_limit(self::get('PHP', 'timeLimit'));
        ini_set('max_execution_time', self::get('PHP', 'timeLimit'));
        ini_set('memory_limit', self::get('PHP', 'memoryLimit'));

        ini_set('error_prepend_string', '<div class="red">');
        ini_set('error_append_string', '</div><div class="rb"><br/></div>' . Registry::get('foot'));
        ini_set('error_log', Errors::getTraceFile());
        set_error_handler('Errors::errorHandler');


        if (self::get('Auth', 'enable')) {
            Auth::main();
        }

        Gmanager::getInstance()->init();
    }


    /**
     * get
     *
     * @param string $section
     * @param string $property
     * @return string
     */
    public static function get ($section = 'Gmanager', $property)
    {
        return self::$_config->get($section, $property);
    }


    /**
     * get
     *
     * @param string $section
     * @return array
     */
    public static function getSection ($section = 'Gmanager')
    {
        return self::$_config->getSection($section);
    }


    /**
     * getTemp
     * 
     * @return string
     */
    public static function getTemp ()
    {
        return GMANAGER_PATH . DIRECTORY_SEPARATOR . 'data';
    }


    /**
     * getContentType
     * 
     * @return string
     */
    public static function getContentType ()
    {
        if (isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') !== false) {
            return 'application/xhtml+xml';
        }
        return 'text/html';
    }


    /**
     * getVersion
     * 
     * @return string
     */
    public static function getVersion ()
    {
        return '0.8.1b';
    }
}

