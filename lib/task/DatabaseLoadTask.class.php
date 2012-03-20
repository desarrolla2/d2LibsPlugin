<?php

class DatabaseLoadTask extends sfBaseTask {

    protected function configure() {
        $this->addOptions(array(
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'local'),
        ));

        $this->namespace = 'rd';
        $this->name = 'load-database';
        $this->briefDescription = '';
        $this->detailedDescription = '';
    }

    protected function execute($arguments = array(), $options = array()) {
        $this->db = rdLightDb::getInstance()->initialize($options['env']);

        $file = sfConfig::get('sf_data_dir') . '/tmp/fixtures.sql';

        if (!file_exists($file)) {
            throw new Exception('fixtures.sql not found');
        }

        $this->logSection('db', 'fixtures load');       
        $this->db->mysqlLoad($file);

        $this->logSection('db', 'fixtures sucesfull loaded!');
    }

}
