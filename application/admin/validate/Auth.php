<?php

namespace app\admin\validate;
use think\Validate;
class Auth extends Validate{

    protected $rule = [
        'auth_name' => 'require|unique:auth',
        'pid'       => 'require',
        'auth_c'    => 'require',
        'auth_a'    => 'require',
    ];

    protected $message = [
        'auth_name.require' => '權限名稱必須填寫',
        'auth_name.unique'  => '權限名稱已經存在',
        'pid.require'       => '請選擇父級權限',
        'auth_c.require'    =>'非頂級權限必須填寫控制器',
        'auth_a.require'    =>'非頂級權限必須填寫方法名',
    ];

    protected $scene   = [ 
        'add'        =>['auth_name','pid','auth_c','auth_a'],
        'upd'        =>['auth_name','pid','auth_c','auth_a'],
        'top'        =>['auth_name','auth_c','auth_a'],
        'spacil'     =>['auth_name'],
    ];
}