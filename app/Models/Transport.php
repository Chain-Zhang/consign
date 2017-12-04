<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/26
 * Time: 下午11:10
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public $table = 'transport';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function getPaymentStatus()
    {
        switch ($this->payment_status){
            case 0:
                return '未付款';
            case 1:
                return '已付款';
            default:
                return '未知';
        }
    }

    public function getPaymentMethod(){
        switch ($this->payment_method){
            case 1:
                return '现付';
            case 2:
                return '到付';
            default:
                return '未知';
        }
    }
}