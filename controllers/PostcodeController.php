<?php

class PostcodeController {

    private $objPostcodeRepository;
    private $arrMessages;
    private $arrPostcodes;

    public function __construct() {

        $objRestClient = new RestClient();
        $this->objPostcodeRepository = new PostcodeRepository($objRestClient);
    }

    public function getAllPostcodes() {
        $this->arrPostcodes = $this->objPostcodeRepository->getAllPostcodes();

        if (!$this->arrPostcodes)
        {
            $this->arrMessages = $this->objPostcodeRepository->getMessages();
            return false;
        }

        return $this->arrPostcodes;
    }

    /**
     * 
     * @param type $longitude
     * @param type $latitude
     */
    public function getNearestPostcodesFromLongLat($longitude, $latitude) {

        $this->arrPostcodes = $this->objPostcodeRepository->getNearestPostcodesFromLongLat($longitude, $latitude);

        if (!$this->arrPostcodes)
        {
            $this->arrMessages = $this->objPostcodeRepository->getMessages();
            return false;
        }

        return $this->arrPostcodes;
    }

    /**
     * 
     * @param type $postcode
     */
    public function getPartial($postcode) {
        $this->arrPostcodes = $this->objPostcodeRepository->getPartial($postcode);

        if (!$this->arrPostcodes)
        {
            $this->arrMessages = $this->objPostcodeRepository->getMessages();
            return false;
        }

        return $this->arrPostcodes;
    }

    /**
     * 
     * @param type $blPartial
     * @return boolean
     */
    public function import($blPartial = false) {

        if (empty($this->arrPostcodes))
        {

            return false;
        }

        $objConfig = new Config();
        $objDatabase = new Database($objConfig);
        
        $objImport = new Import($objDatabase);
        $objImport->doImport($this->arrPostcodes, $blPartial);
    }

    public function getMessages() {

        return $this->arrMessages;
    }

}
