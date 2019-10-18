<?php

namespace app\admin\controller;
// use think\controller;
use app\admin\model\User;
use app\admin\model\Role;
class UserController extends CommonController{

    public function del(){
        $user_id = input('user_id');
        if(User::destroy($user_id)){
            $this->success('刪除成功',url('/admin/user/index'));
        }else{
            $this->errot('刪除失敗');
        }
    }
    public function upd(){
        //1.判斷是否接收數據
        if(request()->isPost()){

            //2.接收Post數據
            $postDate=input('post.');

            //3.驗證器驗證
            //當密碼有一個不為空就必須要驗證
            if($postDate['password']!=''||$postDate['repassword']!=''){

                //說明用戶需要更新密碼,則需要判斷
                $result = $this->validate($postDate,'User.upd',[],true);
                    if($result!==true){
                      $this->error(implode(',',$result));
                     }
            }

        //4.寫入數據庫
        $userModel = new User();
   
        if($userModel->allowField(true)->isUpdate(true)->save($postDate)){
            $this->success('修改成功',url("/admin/user/index"));
        }else{
            $this->error('修改失敗');
        }
    }
        //獲取數據
        $user_id = input('user_id');

        //數據回顯
        $userDate = User::find($user_id);

        //渲染模板
        return $this->fetch('',[
            'userDate'=>$userDate
        ]);
    }
    public function index(){
        //取出數據
        // $userModel = new User();
        // $usersDate = User::select();

        //分頁
            $usersDate = User::order('user_id desc')->paginate(2);

        //渲染模板
        return $this->fetch('',[
            //分配變量
            'usersDate' => $usersDate
        ]);

    }

    public function add(){
        //1)判斷是否接收數據
        if(request()->isPost()){

            //2)接收post參數
            $postData = input('post.');
            //3)驗證器驗證
            $result = $this->validate($postData,"User.add",[],true);

            if($result !== true){
                $this->error(implode(',',$result));
            }
            // //4)寫入數據庫
            $userModel = new User();

            if($userModel->allowField(true)->save($postData)){
                $this->success('添加成功',url("admin/user/index"));
            }else{
                $this->error('添加失敗');
            }
            
        }

        $roles = Role::select();
        //渲染模板
        return $this->fetch('',[
            'roles'=>$roles
        ]);
    }
}