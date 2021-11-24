<?php


namespace App\Classes\Converter;

use Illuminate\Support\Collection;

class OrderConverter
{

    /** 응답값 세팅
     * @param Collection $orders
     * @return Collection
     */
    public static function makeOrderListData(Collection $orders)
    {
        return $orders->map(function($o){
            return [
                'id'=>$o->id,
                'orderId'=>$o->order_id,
                'productName'=>$o->product_name,
                'paymentDate'=>$o->payment_date,
                'orderDate'=> $o->order_date
            ];
        });

    }

}
