<?php

/**
 * PluginrdMenuCredentials
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sinersis
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginrdMenuCredentials extends BaserdMenuCredentials {

    public function save(Doctrine_Connection $conn = null) {



        parent::save($conn);
    }

    public function delete(Doctrine_Connection $conn = null) {

       
        parent::delete($conn);
    }

    public function getName(){
        return $this->getSfGuardPermission()->getName();
    }

}