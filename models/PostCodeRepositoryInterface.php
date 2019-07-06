<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author michael.hampton
 */
interface PostCodeRepositoryInterface {

    /**
     * 
     * @param type $longitude
     * @param type $latitude
     */
    public function getNearestPostcodesFromLongLat($longitude, $latitude);
    
    /**
     * 
     * @param string $postcode
     * @param int $limit
     */
    public function getPartial(string $postcode, int $limit);
    
    public function getAllPostcodes();
}
