<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostcodeRepository
 *
 * @author michael.hampton
 */
class PostcodeRepository implements PostCodeRepositoryInterface {

    private $objRestClient;
    private $url = "https://api.postcodes.io";
    private $arrMessages = [];

    /**
     * 
     * @param RestClientInterface $objRestClient
     */
    public function __construct(RestClientInterface $objRestClient) {
        $this->objRestClient = $objRestClient;
    }

    /**
     * 
     * @param type $longitude
     * @param type $latitude
     * @return boolean
     */
    public function getNearestPostcodesFromLongLat($longitude, $latitude) {

        $this->arrMessages = [];

        if (empty($longitude))
        {
            $this->arrMessages[] = 'Longitude field cannot be empty';
            return false;
        }

        if (empty($latitude))
        {
            $this->arrMessages[] = 'Latitude field cannot be empty';
            return false;
        }

        $jsonurl = $this->url . "/postcodes?lon=" . $longitude . "&lat=" . $latitude;
        $json = $this->objRestClient->request($jsonurl);

        $decoded = json_decode($json, true);

        if ($decoded['status'] == 200)
        {
            return $decoded['result'];
        }

        $this->arrMessages[] = 'Unable to get postcodes';
        return false;
    }

    /**
     * 
     * @return boolean
     */
    public function getAllPostcodes() {

        $this->arrMessages = [];

        $jsonurl = $this->url . "/random/postcodes/";
        $json = $this->objRestClient->request($jsonurl);

        $decoded = json_decode($json, true);

        if ($decoded['status'] == 200)
        {
            return array($decoded['result']);
        }

        $this->arrMessages[] = 'Unable to get postcodes';
        return false;
    }

    /**
     * 
     * @param string $postcode
     * @param int $limit
     * @return boolean
     */
    public function getPartial(string $postcode, int $limit = 99) {

        $this->arrMessages = [];

        if (empty($postcode))
        {
            $this->arrMessages[] = 'Postcode field cannot be empty';
            return false;
        }

        $jsonurl = $this->url . "/postcodes/" . $postcode . "/autocomplete?limit=99";
        $json = $this->objRestClient->request($jsonurl);

        $decoded = json_decode($json, true);

        if ($decoded['status'] == 200)
        {
            return $decoded['result'];
        }

        $this->arrMessages[] = 'Unable to get postcodes';
        return false;
    }

    public function getMessages() {
        return $this->arrMessages;
    }

}
