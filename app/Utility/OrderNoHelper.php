<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/11/5
 * Time: 下午4:03
 */

namespace App\Utility;

class OrderNoHelper
{
    public static  function GetOrderNo(){
        $number = 'ZW'. date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);;
        return $number;
    }
}