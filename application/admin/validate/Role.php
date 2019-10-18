<?php

namespace app\admin\validate;
use think\Validate;
class Role extends Validate{

    protected $rule = [
        'role_name' => 'require|unique:role'
    ];

    protected $message = [
        'role_name.require' => '角色名稱必須填寫',
        'role_name.unique'  => '角色名稱已經存在',        
    ];

    protected $scene = [
        'add' => ['role_name'],
        'upd' => ['roel_name.require']
    ];



}
