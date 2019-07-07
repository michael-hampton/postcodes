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
interface ImportInterface {
    
    /**
     * 
     * @param array $arrPostcodes
     */
    public function doImport(array $arrPostcodes) : bool;
}
