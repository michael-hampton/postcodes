<?php

class Import implements ImportInterface {

    private $objDatabase;
    private $connection;
    private $arrErrors = [];
    private $query_string;
    private $arrParams = [];
    private $count = 0;

    /**
     * 
     * @param DatabaseInterface $objDatabase
     */
    public function __construct(DatabaseInterface $objDatabase) {
        $this->objDatabase = $objDatabase;
    }

    /**
     * 
     * @return boolean
     */
    private function getConnection() {

        if (!isset($this->connection))
        {

            $this->connection = $this->objDatabase->getConnection();
        }

        return true;
    }

    /**
     * 
     * @param array $arrPostcodes
     * @return boolean
     */
    public function doImport(array $arrPostcodes, $blPartial = false): bool {

        if (empty($arrPostcodes))
        {

            return false;
        }

        if (!$this->getConnection())
        {

            return false;
        }

        if ($blPartial)
        {
            $this->addPartialPostCodeToQuery($arrPostcodes);
        }
        else
        {
            $this->addPostcodeToQuery($arrPostcodes);
        }

        if (!$this->savePostcodesToDatabase())
        {

            return false;
        }

        die('good');

        return true;
    }

    /**
     * 
     * @return boolean
     */
    private function savePostcodesToDatabase() {
        $this->query_string = rtrim($this->query_string, ",");

        try {
            $stmt = $this->connection->prepare($this->query_string);
            $stmt->execute($this->arrParams);

            die('Mike');
        } catch (Exception $ex) {

            $this->arrErrors[] = 'Unable to add to database';
            return false;
        }

        return true;
    }

    /**
     * 
     * @param array $arrPostcodes
     * @return boolean
     */
    public function addPartialPostCodeToQuery(array $arrPostcodes) {


        $this->query_string = "INSERT INTO postcodes (postcode) VALUES ";
        $this->count = 0;
        $this->arrParams = [];


        foreach ($arrPostcodes as $strPostcode)
        {
            $this->query_string .= "(:postcode{$this->count}),";
            $this->arrParams["postcode{$this->count}"] = $strPostcode;

            $this->count++;
        }

        return true;
    }

    /**
     * 
     * @param array $arrPostcodes
     * @return boolean
     */
    private function addPostcodeToQuery(array $arrPostcodes) {


        $this->query_string = "INSERT INTO postcodes (postcode) VALUES ";
        $this->count = 0;
        $this->arrParams = [];

        foreach ($arrPostcodes as $arrPostcode)
        {
            $this->query_string .= "(:postcode{$this->count}),";
            $this->arrParams["postcode{$this->count}"] = $arrPostcode['postcode'];

            $this->count++;
        }

        return true;
    }

    public function getErrors() {

        return $this->arrErrors;
    }

}
