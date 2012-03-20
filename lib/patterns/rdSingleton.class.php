<?php
require_once sfConfig::get('sf_plugins_dir') . '/rdLibsPlugin/lib/retro/get_called_class.php';

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: rdSinersisUser 1.0  11-ago-2010 13:08:44
 *
 * @file        : rdMainMenu.class.php , UTF-8
 * @date        : 11-ago-2010 , 13:08:44
 */

/*
 * rdSingleton singleton pattern
 *
 */
class rdSingleton {

    private static $instances = array();

    final public function __construct() {
        if (isset(self::$instances[get_called_class()])) {
            throw new Exception(" A " . get_called_class() . " instance already exist");
        }
        $this->initialize();
    }

    protected function initialize() {

    }

    final public static function getInstance($cacheFile = null) {

        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

}


