<?php

namespace app\admin\model;
use think\model;
class Goods extends Model{

    protected $pk = "goods_id";

    protected $autoWriteTimestamp = true;

    public static function init(){

        Goods::event('before_insert',function($goods){

            $goods['goods_sn'] = date('ymd').time().uniqid();
        });
    }



}




