<?php
namespace app\admin\model;
use think\model;
use app\admin\model\Role;
use app\admin\model\Auth;
class User extends Model{

    protected $pk = "user_id";

    protected $autoWriteTimestamp = true;

    protected static function init(){

        User::event("before_insert",function($user){
            //把密碼加密加鹽
            $user['password'] = md5($user['password'].config('password_salt'));
        });

        User::event("before_update",function($user){

            //如果密碼為空刪除password字段
            if($user['password'] == ''){
                unset($user['password']);               
            }else{
            //把密碼加密加鹽
            $user['password'] = md5($user['password'].config('password_salt'));
            }
        }); 

    }
    public function checkUser($username,$password){
        // where組裝查詢條件

        $where = [
            'password' => md5($password.config('password_salt')),
            'username' => $username,
        ];


        $userInfo = $this->where($where)->find();

        if($userInfo){
            //設置session儲存信息
            session('username',$userInfo['username']);
            session('user_id',$userInfo['user_id']);

            // 使用私有的方法再進一步顯現防越權行為 
            $this->_initRole($userInfo['role_id']);
            return true;
        }else{
            return false;
        }
    }  

    private  function _initRole($role_id){

        $auth_ids_list = Role::where('role_id','=',$role_id)->value('auth_ids_list');

        if($auth_ids_list == '*'){
            $allAuths = Auth::select()->toArray();
        }else{
            $allAuths = Auth::where('auth_id','in',$auth_ids_list)->select()->toArray();
        }

        $auths = [];

        foreach($allAuths as $v){
            $auths[$v['auth_id']] = $v ;
        }

        $childrens =[];

        foreach($allAuths as $v ){
            $childrens[$v['pid']][] = $v['auth_id'];
        }


        session('childrens',$childrens);
        session('auths',$auths);

        //把當前角色權限 保存在session 裡面給與common 控制器 初始化中進行判斷
        if($auth_ids_list == '*'){
            //超級管理員
            session('visitor','*');
        }else{
            // 非超級管理員
            //把控制器和方法進行小寫轉換 ,寫入數組裡面
            $visitor = [];

            foreach($allAuths as $v){
                $visitor[] = strtolower($v['auth_c'].'/'.$v['auth_a']);
            }           
            session('visitor',$visitor);
        }
    }
}
