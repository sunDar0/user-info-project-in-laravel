<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;


class User extends Model
{

    protected $fillable =[
        'name',
        'nick_name',
        'password',
        'email',
        'tel',
        'gender'
    ];
    protected $connection = 'test_db';
    protected $table = 'user';

    public function order()
    {
        return $this->hasMany('App\Models\Order','user_id','id');
    }

    public function lastOrder()
    {
        return $this->hasOne('App\Models\Order','user_id','id')->latest('order_date');
    }

    public function sysCodeDtl()
    {
        return $this->hasMany('App\Models\SmartCall\Managed\SysCodeDtl','code_id','status_cd');
    }

}
