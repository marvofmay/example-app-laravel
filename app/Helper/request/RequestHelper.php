<?php

namespace App\Helper\request;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestHelper
 *
 * @author Marcin
 */
class RequestHelper {
    
    public static function getParamsFromURL (string $str): array {
        
        $params = [];
        
        foreach (explode('&', $str) as $item) {
            $arr = explode('=', $item);
            if (count($arr) > 1) {
                $params[$arr[0]] = $arr[1];
            }
        }        
        
        return $params;
    }
}
