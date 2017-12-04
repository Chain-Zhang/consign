<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/19
 * Time: 下午11:22
 */

namespace App\Models;


class ConsignResult
{
    public $status;
    public $message;

    public function toJson(){
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}