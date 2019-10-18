<?php

namespace app\admin\controller;
use think\controller;
use app\admin\model\Auth;
use app\admin\model\Role;
use think\Db;
class RoleController extends CommonController{

    public function del(){
        $role_id = input('role_id');

        if(Role::destroy($role_id)){
            $this->success('刪除成功',url('/admin/role/index'));
        }else{
            $this->error('刪除失敗');
        }
    }

    public function upd(){
        if(request()->isPost()){
            $postData = input('post.');
            
            $result = $this->validate($postData,'Role.upd',[],true);

            if($result!==true){
                $this->error(implode(',',$result));
            }

            $roleModel = new Role;
      
            if($roleModel->update($postData)){
                $this->success('更新成功', url('/admin/role/index'));
            }else{
                $this->error('更新失敗');
            }
        }
   

        $role_id = input('role_id');

        $roleModel = new Role;

        $roledata = $roleModel->find($role_id);

        $authModel = new Auth();

        $oldAuths = $authModel->select()->toArray();

        //遍歷$oldAuths 二維數組 以每個元素的auth_id 作為下標
        $auths = [];

        foreach($oldAuths as $v){
            $auths[$v['auth_id']] = $v;
        };

        //遍歷$oldAuths 二維數組 通過Pid的值進行分組

        $chilrens = [];

        foreach($oldAuths as $v ){
            $chilrens[$v['pid']][] = $v['auth_id'] ;
        }

        return $this->fetch('',[
            'roledata' =>$roledata,
            'auths' =>$auths,
            'chilrens'=>$chilrens
        ]);
    }

    public function index(){
        // 取出所有角色
        // $roles = Role::select();
        $sql = " select t1.* ,GROUP_CONCAT(t2.auth_name SEPARATOR '|') allauth from sh_role t1 left join sh_auth t2 on FIND_IN_SET(t2.auth_id,t1.auth_ids_list)group by t1.role_id";

        $roles = Db::query($sql);
        return $this->fetch('',[
            'roles' =>$roles
        ]);
    }

    public function add(){
        if(request()->isPost()){
            $postData =input('post.');

            $result = $this->validate($postData,'role.add',[],true);

            if($result!==true){
                $this->error(implode(',',$result));
            }   

            $roleModel = new Role;

            if($roleModel->save($postData)){
                $this->success('添加成功',url('/admin/role/index'));
            }else{
                $this->error('添加失敗');
            }


        }



        $authModel = new Auth();

        $oldAuths = $authModel->select()->toArray();

        //遍歷$oldAuths 二維數組 以每個元素的auth_id 作為下標
        $auths = [];

        foreach($oldAuths as $v){
            $auths[$v['auth_id']] = $v;
        };

        //遍歷$oldAuths 二維數組 通過Pid的值進行分組

        $chilrens = [];

        foreach($oldAuths as $v ){
            $chilrens[$v['pid']][] = $v['auth_id'] ;
        }

        //渲染模板
        return $this->fetch('',[
            'auths' =>$auths,
            'chilrens' =>$chilrens
        ]);
    }


}