<?php 
namespace app\home\validate;
use think\Validate;
class Member extends Validate{
	//规则
	protected $rule = [
        'username' => 'require|unique:member',
        'email' =>'require|email|unique:member',
		'password' => 'require',
        //confirm:password => 要求repassword字段的值和password的值保持一致
		'repassword' => 'require|confirm:password',
		'captcha'	=> 'require|captcha:1',
		'phoneCaptcha' =>'require'

	];
	//信息
	protected $message = [
		'username.require' => '用户名必填',
        'username.unique' => '用户名占用',
        'email.require' => '郵箱必須填寫',
        'email.eamil'   => '郵箱必須按照格式填寫',
        'email.unique'  => '郵箱被佔用',
		'password.require' => '密码必填',
		'repassword.require' => '确认密码必填',
		'repassword.confirm' => '两次密码不一致',
		'captcha.require' => '验证码必填',
		'captcha.captcha' => '验证码输入有误',
		'phoneCaptcha.require' =>'必須填寫手機驗證碼',

	];
	//场景
	protected $scene = [
		'add' =>['username','password','repassword','email','phoneCaptcha'],
		'login' => ['username.require','password.require','captcha',],
	];
}