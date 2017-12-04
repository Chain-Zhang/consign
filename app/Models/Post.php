<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/12
 * Time: 下午10:15
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'post';
    public $primaryKey = 'id';
    public $timestamps = true;
}