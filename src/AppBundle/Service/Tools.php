<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 5.9.17
 * Time: 10.23
 */

namespace AppBundle\Service;


class Tools
{
    public function getDebugString($var){
        ob_start();
        print_r($var);
        return ob_get_clean();
    }
}