<?php

class DatabaseBackupTask extends sfBaseTask {

    protected function configure() {

        $this->addOptions(array(
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'local'),
        ));

        $this->namespace = 'rd';
        $this->name = 'backup-prod-database';
        $this->briefDescription = '';
        $this->detailedDescription = '';
    }

    protected function execute($arguments = array(), $options = array()) {
         
        $this->db = rdLightDb::getInstance()->initialize('prod');
        $file = sfConfig::get('sf_data_dir') . '/tmp/fixtures.sql';        
        
        $this->logSection('db', 'fixtures dump');
        $cmd = $this->db->mysqlDump($file);        
        
        $this->logSection('db', 'fixtures sucesfull dumped!');
        copy($file, sfConfig::get('sf_data_dir') . '/tmp/fixtures_' . $start_at = date('Ymd_His') . '.sql');
                
        $this->logSection('cp', 'fixtures sucesfull copied!');
    }
}