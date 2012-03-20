<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : sinersis
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: ImportsLogs 1.0  24-ago-2010 15:40:04
 *
 * @file        : rdLightDb , UTF-8
 * @date        : 08-Nov-2010 , 15:40:04
 */

/**
 * rdLightDb class
 *
 * This class has been created in order to integrate all systems
 */
class rdLightDb extends rdSingleton {

    protected $con = null;
    protected $select_db = null;
    protected $queries = array();
    protected $query = null;
    protected $errors = array();
    protected $environment = null;
    protected $db_options = array();
    protected $db_yml = array();
    
    protected function dropDatabase(){
        $query = 'DROP DATABASE IF EXISTS ' . $this->db_options['database'] . ';';
        $this->query($query);        
    }
    
    protected function createDatabase(){
        $query = 'CREATE DATABASE ' . $this->db_options['database'] . ' COLLATE utf8_unicode_ci;';
        $this->query($query);        
    }
    
    public function mysqlLoad($file_name){
        $this->dropDatabase();
        $this->createDatabase();
        $cmd =  'mysql -u ' . $this->db_options['username'] . ' -p' . $this->db_options['password'] .
                ' -h ' . $this->db_options['host'] . ' ' . $this->db_options['database'] .
                ' --verbose --quick < ' . $file_name;        
        return exec($cmd);
    }
    
    public function mysqlDump($file_name){
        $cmd = 'mysqldump -u ' . $this->db_options['username'] . ' -p' . $this->db_options['password'] .
                ' -h ' . $this->db_options['host'] . ' ' . $this->db_options['database'] .
                ' --add-drop-table --add-locks --create-options --disable-keys --extended-insert ' .
                ' --quick --set-charset --compress --verbose  --no-create-db > ' .  //--compatible=mysql40
                $file_name;
        return exec($cmd);
    }

    protected function setEnvironment($environment = null) {
        if (!$environment) {
            $environment = sfConfig::get('sf_environment');
        }
        if (!$environment) {
            throw new Exception('Cant set environment');
        }
        $this->environment = $environment;
    }

    protected function parseYml() {
        $this->db_yml = sfYaml::load(sfConfig::get('sf_config_dir') . '/databases.yml');
    }

    protected function setOptions() {
        $this->parseYml();
        $options = array('username', 'password', 'dsn', 'default_table_charset');
        foreach ($options as $option) {
            $this->setOption($option);
        }
        $this->parseDsn();
    }

    protected function setOption($option = null) {
        if (!$option) {
            throw new Exception('Option or option name not set');
        }
        if (isset($this->db_yml[$this->environment]['doctrine']['param'][$option])) {
            $this->db_options[$option] = $this->db_yml[$this->environment]['doctrine']['param'][$option];
        } elseif (isset($this->db_yml['all']['doctrine']['param'][$option])) {
            $this->db_options[$option] = $this->db_yml['all']['doctrine']['param'][$option];
        } else {
            throw new Exception('Option: ' . $option . ' not available for environment :' . $this->environment);
        }
    }

    protected function parseDsn() {
        $dsn = $this->db_options['dsn'];
        $dsn = str_replace('mysql:host=', '', $dsn);
        $dsn = str_replace('dbname=', '', $dsn);
        $dsn = explode(';', $dsn);
        $this->db_options['host'] = $dsn[0];
        $this->db_options['database'] = $dsn[1];
    }

    protected function mysqlConnect() {            
        $this->con = mysql_connect($this->db_options['host'], $this->db_options['username'], $this->db_options['password']);
        $this->set_charset($this->db_options['default_table_charset']);
        if ($this->con) {
            $this->select_db = mysql_select_db($this->db_options['database']);
        }
        if (!$this->con || !$this->select_db) {
            throw new Exception('initialize Mysql Error (' . $this->environment . '):' . mysql_error());
        }
    }

    public function initialize($enviroment = null) {
        $this->setEnvironment($enviroment);
        $this->setOptions();
        $this->mysqlConnect();

        return $this;
    }

    public function __destruct() {
        if ($this->con) {
            mysql_close($this->con);
        }
    }

    /**
     * returns the last error occurred,
     * removed it from the stack or false if
     * no errors
     *
     * @return  string $error or false
     */
    public function getError() {
        $error = array_pop($this->errors);
        if ($error) {
            return $error;
        } else {
            return false;
        }
    }

    /**
     * returns the error stack or false if
     * no error
     *
     * @return  array $errors or false
     */
    public function getErrorStack() {
        if ($this->errors) {
            return $this->errors;
        } else {
            return false;
        }
    }

    /**
     * returns number errors in this session or 0
     *
     *  @return int $n
     */
    public function countErrors() {
        if ($this->errors) {
            return count($this->errors);
        } else {
            return 0;
        }
    }

    /**
     * returns number query executed in this session or 0
     *
     *  @return int $n
     */
    public function countQueries() {
        if ($this->queries) {
            return count($this->queries);
        } else {
            return 0;
        }
    }

    /**
     * returns query executed in this session or false
     *
     *  @return array $queries or false
     */
    public function getQueries() {
        if ($this->queries) {
            return $this->queries;
        } else {
            return false;
        }
    }

    private function cleanQuery() {
        $this->query = preg_replace('#\/\*[^(*\/)]+\*\/#', ' ', $this->query);
        $this->query = preg_replace('#\s+#', ' ', $this->query);
        $this->query = trim($this->query);
    }

    public function query($query, $clean = true) {
        $this->query = $query;
        if ($clean) {
            $this->cleanQuery();
        }
        array_push($this->queries, $this->query);
        $result = mysql_query($this->query);
        $error = mysql_error();
        if ($error) {
            array_push($this->errors, $error);
            return false;
        }
        return $result;
    }

    public function fetch_object($query) {
        $result = $this->query($query);
        if ($result) {
            return mysql_fetch_object($result);
        } else {
            return false;
        }
    }

    public function fetch_objects($query) {
        $items = array();
        $result = $this->query($query);
        if ($result) {
            while ($item = mysql_fetch_object($result)) {
                array_push($items, $item);
            }
            return $items;
        } else {
            return false;
        }
    }

    public function fetch_arrays($query) {
        $items = array();
        $result = $this->query($query);
        if ($result) {
            while ($item = mysql_fetch_array($result)) {
                array_push($items, $item);
            }
            return $items;
        } else {
            return false;
        }
    }

    public function set_charset($new_charset) {
        return mysql_set_charset($new_charset, $this->con);
    }

    public function change_charset($new_charset) {
        return $this->set_charset($new_charset);
    }

}

