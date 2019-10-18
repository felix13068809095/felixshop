<?php

namespace app\admin\validate;
use think\Validate;
class Goods extends Validate{

    protected $rule = [
        'goods_name'   => 'require|unique:goods',
        'cat_id'       => 'require',
        'goods_price'  => 'require|gt:0',
        'goods_number' => 'require|regex:^\d+$',

    ];

    protected $message = [
        'goods_name.require' => '商品名稱名稱必須填寫',
        'goods_name.unique'  => '商品名稱已經存在',
        'cat_id.require'       => '請選擇商品類型',
        'goods_price.require'    =>'商品價格必須填寫',
        'goods_price.gt'    => '商品價格必須大於0',
        'goods_number.require'    =>'商品數量必須填寫',
        'goods_number.regex'    =>'商品數量必須大於0',
    ];

    protected $scene   = [ 
        'add'   =>['goods_name','cat_id','goods_price','goods_number'],
    ];
}