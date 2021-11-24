<?php


namespace App\Classes\Converter;

use App\Http\Request\RequestGetUserList;
use App\Models\User;

use App\Traits\TraitWhereConditioner;


class UserConverter
{
    use TraitWhereConditioner;

    /**
     * @param $users
     * @return mixed
     */
    public static function makeUserListData($users)
    {
        return $users->map(function($u){

            return [
                'id'=>$u->id,
                'name' => $u->name,
                'nickName'=>$u->nick_name,
                'email'=>$u->email,
                'tel'=>$u->tel,
                'gender'=>$u->gender,
                'lastOrder' => $u->lastOrder ?
                    [
                        'id'=>$u->lastOrder->id,
                        'orderId'=>$u->lastOrder->order_id,
                        'productName'=>$u->lastOrder->product_name,
                        'paymentDate'=>$u->lastOrder->payment_date,
                        'orderDate'=>$u->lastOrder->order_date,
                    ] : null
            ];
        });
    }

    public static function makeUserDetailData(User $user)
    {
        return [
            'id'=>$user->id,
            'name' => $user->name,
            'nickName'=>$user->nick_name,
            'email'=>$user->email,
            'tel'=>$user->tel,
            'gender'=>$user->gender,
        ];
    }

    public static function makeWhereCondition(RequestGetUserList $request)
    {
        $cond = [];
        if(!empty($request->name)) $cond['name'] = ['val' => $request->name, 'operator' => '='];
        if(!empty($request->email)) $cond['email'] = ['val' => $request->email, 'operator' => '='];

        return self::setWhereCondition($cond);

    }
}
