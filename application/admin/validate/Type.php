<?php

namespace app\admin\validate;
use think\Validate;
class Type extends Validate{

    protected $rule = [
        "type_name" =>"require|unique:type"
    ];

    protected $message = [
        "type_name.require" => '商品名稱必填',
        'role_name.unique'  => '角色名稱已經存在', 
    ];

    protected $scene = [
       'add' => ['type_name'],
       'upd' => ['type_name.']
    ];
}