<?php

/**
 * PluginrdMenuItems
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sinersis
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginrdMenuItems extends BaserdMenuItems {

    public function save(Doctrine_Connection $conn = null) {

        if ($this->ord == '') {
            $this->ord = Doctrine_Query::create()
                            ->from('RdMenuItems')
                            ->select('MAX(ord) as ord')
                            ->where('parent_id = ?', array($this->parent_id))
                            ->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR) + 1;
        }
        return parent::save();
    }

    /**
     * Search for children related items in database, return false
     * if any children has find, or the number of children found.
     *
     * return int or false
     */
    public function hasChildrens() {
        return Doctrine_Query::create()
                ->from('RdMenuItems')
                ->select('COUNT(id) as n')
                ->where('parent_id = ?', array($this->getId()))
                ->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
        ;
    }

    /**
     * Search for children related items in database,
     * 
     * @return <Doctrine_Collection>
     */
    public function getChildrens() {

        return Doctrine_Query::create()
                ->from('RdMenuItems')
                ->where('parent_id = ?', array($this->getId()))
                ->orderBy('ord ASC')
                ->execute();
    }

    /**
     * Return related modules in database.
     *
     * @return <Doctrine_Collection>
     */
    public function getModules() {

        return Doctrine_Query::create()
                ->from('RdMenuModules')
                ->where('rd_main_menu_item_id = ?', array($this->getId()))
                ->execute();
    }

    /**
     * Return related credentials in database.
     *
     * @return <Doctrine_Collection>
     */
    public function getCredentials() {

        return Doctrine_Query::create()
                ->from('RdMenuCredentials')
                ->where('rd_main_menu_item_id = ?', array($this->getId()))
                ->execute();
    }

}