<?php

namespace app\home\controller;
use think\controller;
use app\home\model\Member;
class PublicController extends Controller{

    public function sendSms(){
        // 1.判斷是否ajax請求
        if(request()->isAjax()){
            // 2.接收手機號
            $phone = input('phone');

            $result = Member::where('phone','=',$phone)->find();

            if($reuslt){
                // 已經被註冊了
                $response = ['code' => -1 ,'message'=>'手機號已被註冊'];
                echo json_encode($response);die;
            }
            // 3.確保手機號沒有被註冊過
            $rand = mt_rand(1000,9999);
            
            $SmsResult = sendSms($phone,[$rand,5]);

            if($SmsResult->statusCode == '000000'){
                // 把驗證碼加密的結果寫入cookies ,有效期5分鐘
                // cookie('name', 'value', 3600);
                cookie('smscode',md5($rand.config('sms_salt')),300);
                $response = ['code'=>200,'message'=>'驗證碼啊發送成功'];
                echo json_encode($response);die;
            }else{
                $response = ['code '=> -2 , 'message'=>'發送失敗或'.$SmsResult->statusMsg];
                echo json_encode($response);die;
            }
        }
        
       
        // 4.調用發送短信的方法進行短信發送
    }

    public function logout(){
        session('user_name',null);
        session('user_id',null);

        $this->redirect('/home/public/login');
    }

    public function login(){

        if(request()->isPost()){
            $postData = input('post.');

            $result = $this->validate($postData,"member.login",[],true);
 
            if($result !== true){
                $this->error(implode(',',$result));
            }

            $memberModel = new Member();

            $status = $memberModel->checkMember($postData['username'],$postData['password']);

            if($status){
                
                $this->success('登錄成功',url("home/index/index"));
            }else{
                $this->error('登錄失敗');
            }

        }



        // 渲染模板
        return $this->fetch();
    } 

    public function register(){

        //1)判斷是否接收數據
        if(request()->isPost()){

            //2)接收post參數
            $postData = input('post.');

            // 驗證輸入的驗證碼是否正確
            $phonecode = md5($postData['phoneCaptcha'].config('sms_salt'));

            // 加密結果不一樣,手機驗證失敗
            if(cookie('smscode') != $phonecode){
                $this->error('手機驗證碼錯誤,請重新輸入');
            }

            //3)驗證器驗證
            $result = $this->validate($postData,"member.add",[],true);

            if($result !== true){
                $this->error(implode(',',$result));
            }

            // //4)寫入數據庫
            $memberModel = new Member();

            if($memberModel->allowField(true)->save($postData)){

                cookie('smscode',null);
                $this->success('添加成功',url("home/public/login"));
            }else{
                $this->error('添加失敗');
            }
            
        }

        // 渲染模板
        return $this->fetch();
    }
}