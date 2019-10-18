<?php
namespace app\admin\controller;
use think\controller;
use app\admin\model\User;
class PublicController extends Controller{

    public function logout(){
        session('user_id',null);
        session('username',null);
        $this->redirect('/admin/public/login');
    }
    
    public function login(){
        if(request()->isPost()){

            $postData = input('post.');

            $result = $this->validate($postData,'User.login',[],true);

            if($result!==true){
                $this->error(implode(',',$result));
            }

            $userModel = new User;
            
            $status = $userModel->checkUser($postData['username'],$postData['password']);
            if($status){
                $this->success('登錄成功',url('/admin/index/index'));
            }else{
                $this->error('用戶名或者密碼錯誤');
            }
     
        }
        return $this->fetch();
    }
}