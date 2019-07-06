<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestClient
 *
 * @author michael.hampton
 */
class RestClient implements RestClientInterface {

    /**
     * 
     * @param type $jsonurl
     * @return type
     */
    public function request($jsonurl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, str_replace(' ', '%20', $jsonurl));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}
