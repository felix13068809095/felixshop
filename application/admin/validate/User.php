<?php 
namespace app\admin\validate;
use think\Validate;
class User extends Validate{
	//规则
	protected $rule = [
		'username' => 'require|unique:user',
		'password' => 'require',
		//confirm:password => 要求repassword字段的值和password的值保持一致
		'repassword' => 'require|confirm:password',
		'captcha'	=> 'require|captcha'

	];
	//信息
	protected $message = [
		'username.require' => '用户名必填',
		'username.unique' => '用户名占用',
		'password.require' => '密码必填',
		'repassword.require' => '确认密码必填',
		'repassword.confirm' => '两次密码不一致',
		'captcha.require' => '验证码必填',
		'captcha.captcha' => '验证码输入有误'
	];
	//场景
	protected $scene = [
		'add' =>['username','password','repassword'],
		'upd' =>['password','repassword'],
		'login' =>['username'=>"require",'password','captcha']
	];
}