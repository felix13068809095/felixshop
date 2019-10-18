<?php

namespace  app\home\model;
use think\model;
class Member extends Model{

    protected $pk = 'member_id';

    protected $autoWriteTimestamp = true;

    protected static function init(){

        Member::event("before_insert",function($member){
            //把密碼加密加鹽
            $member['password'] = md5($member['password'].config('password_salt'));
        });
    }

    public function checkMember($username,$password){
        // 組裝查詢條件
        $where = [
            'password' => md5($password.config('password_salt')),
            'username' => $username 
        ];

        $userInfo = $this->where($where)->find();

        if($userInfo){
            // 儲存用戶信息session
            session('username',$userInfo['username']);
            session('user_id',$userInfo['member_id']);

            return true;
        }else{
            return false;
        }
    }
}