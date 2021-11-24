<?php

namespace App\Traits;

trait TraitWhereConditioner
{
    //where 절 생성
    public static function setWhereCondition($condData)
    {
        $whereCond = [];
        foreach($condData as $key => $value ) {
            $whereCond[] = [$key, $value['operator'], $value['val']];
        }

        return $whereCond;
    }
}
