<?php 
namespace app\admin\validate;
use think\Validate;
class Attribute extends Validate{
	protected $rule = [
		'attr_name' => 'require|unique:attribute',
		'type_id'		=> 'require',
		'attr_values' 	=>'require'
	];

	protected $message = [
		'attr_name.require' => '属性名称必填',
		'attr_name.unique' => '属性名称占用',
		'type_id.require' => '请选择商品类型',
		'attr_values.require' => '列表选择时属性值不能为空'
	];

	protected $scene = [
		//给列表选择验证的
		'add' => ['attr_name','type_id','attr_values'],
		'upd' => ['attr_name','type_id','attr_values'],
		//手工输入
		'special' => ['attr_name','type_id']
	];

}