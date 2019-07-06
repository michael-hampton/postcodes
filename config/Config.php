<?php

class Config {

    private $arrConfig = array(
        'db_host' => 'localhost',
        'db_user' => 'mike',
        'db_pass' => 'test123',
        'db_name' => 'test'
    );

    public function getConfig() {

        return $this->arrConfig;
    }

}
