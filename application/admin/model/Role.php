<?php

namespace app\admin\model;
use think\model;
class Role extends Model{

    protected $pk = "role_id" ;

    protected $autoWriteTimestamp = true;

    protected static function init(){
		//入库前事件事件把权限数组格式变为字符串格式
		Role::event('before_insert',function($role){
			$role['auth_ids_list'] = implode(',',$role['auth_ids_list']);
			// halt($role);
		});

		//编辑的前事件，把数组权限变为字符串存入数据表
		Role::event('before_update',function($role){
			$role['auth_ids_list'] = implode(',',$role['auth_ids_list']);
		});
	}
    

    
}