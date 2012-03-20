<?php

/**
 * PluginSystemLoggerTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginSystemLoggerTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object PluginSystemLoggerTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('PluginSystemLogger');
    }

    public static function log($options = array(), SystemLogger $logger = null) {
        if (!$logger){
            $logger = new SystemLogger();
        }       
        if (isset($options['item'])) {
            try {
                $logger->setLoggerId($options['item']->getId());
            } catch (Exception $e) {
                // ..
            }
            try {
                $logger->setName($options['item']->getName());
            } catch (Exception $e) {
                // ..
            }
            $logger->setLoggerClass(get_class($options['item']));
        }
        if (isset($options['level'])) {
            $logger->setLevel($options['level']);
        } else {
            $logger->setLevel('info');
        }
        if (isset($options['link'])) {
            $logger->setLinkl($options['link']);
        }
        if (isset($options['text'])) {
            $logger->setText($options['text']);
        }

        // URL 

        $logger->save();
    }

}