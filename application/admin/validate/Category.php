<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate{

    protected $rule = [
        'cat_name' => 'require|unique:auth',
        'pid'      => 'require',
    ];

    protected $message = [
        'cat_name.require' => '分類名稱必須填寫',
        'cat_name.unique'  => '分類名稱已經存在',
        'pid.require'       => '請選擇父級權限',
    ];

    protected $scene   = [ 
        'add'        =>['auth_name','pid'],
        'upd'        =>['auth_name','pid'],
    ];
}