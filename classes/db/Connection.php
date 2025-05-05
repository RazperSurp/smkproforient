<?php

namespace db;

class Connection {
    public $connect;

    private $_credentials;

    public function __construct($credentials) {
        $this->_credentials = $credentials;
        $this->connect = pg_connect('host='. $this->_credentials['HOSTADDR'] .' port='. $this->_credentials['HOSTPORT'] .' dbname='. $this->_credentials['DATABASE'] .' user='. $this->_credentials['USERNAME'] .' password='. $this->_credentials['PASSWORD']);
    }

    static public function connect($credentials) {
        return (new self($credentials))->connect;
    }
}
?>