<?php
namespace app\admin\controller;
use think\controller;
use app\admin\model\Auth;
class AuthController extends CommonController{

    public function ajaxDelAuth(){
        //  判斷是否ajax
        if(request()->isAjax()){
             // 接收參數
            $auth_id = input('auth_id');

            $authModel = new Auth();
            $sonAuth = $authModel->where('pid','=',$auth_id)->find();

            // 判斷是否子級權限
            if($sonAuth){
                // 刪除失敗 含有子級權限
                $response = ['code' => -1 ,'msg'=>'含有子級權限,無法刪除'];
                return json($response);
            }

            if(Auth::destroy($auth_id)){
                $response = ['code' => 200,'msg'=>'删除成功']; 
                return json($response);
            }else{
                $response = ['code' => -2,'msg'=>'删除失败']; 
                return json($response);
            }

        }
       



    }

    public function upd(){
        //1.
        if(request()->isPost()){
            // 2.
            $postData = input('post.');

            // 3.
            if($postData['pid']== 0){
                $result = $this->validate($postData,'Auth.top',[],true);
            }else{
                $result = $this->validate($postData,'Auth.upd',[],true);
            }

            if($result!==true){
                $this->error(implode(',',$result));
            }
            // 4.
            $authModel = new Auth;

            if($authModel->isUpdate(true)->save($postData)){
                $this->success('更新成功',url('/admin/auth/index'));
            }else{
                $this->error('更新失敗');
            }
        }


        //取出無限級分類
        $authModel = new Auth;

        $oldAuth = $authModel->select()->toArray();
                
        $authAll = $authModel->getSonsAuth($oldAuth); 

        //接收傳送過來ID的資料
        $auth_id = input('auth_id');

        $auths = $authModel::find($auth_id);

       return $this->fetch('',[
           'auths' =>$auths,
           'authAll' =>$authAll
       ]);
    }

    public function index(){

        $authModel = new Auth;

        $auths = $authModel->alias('t1')
                ->field('t1.* , t2.auth_name as p_name')
                ->join('sh_auth t2','t1.pid = t2.auth_id','left')
                ->select();

        $auths = $authModel->getSonsAuth($auths);
        

        return $this->fetch('',[
            'auths' =>$auths
        ]);
    }
    
    public function add(){
        //1.
        if(request()->isPost()){
            //2.
            $postData = input('post.');

            // 3.
            if($postData['pid'] == 0){
                $result = $this->validate($postData,'Auth.spacil',[],true);
            }else{
                $result = $this->validate($postData,'Auth.add',[],true);
            }

            if($result!==true){
                $this->error(implode(',',$result));
            }

            // 4.
            $authModel = new Auth;
            if($authModel->save($postData)){
                $this->success('添加成功',url('/admin/auth/index'));
            }else{
                $this->error('添加失敗');
            }
        }

        //取出無限級分類
        $authModel = new Auth;

        $oldAuth = $authModel->select()->toArray();
        
        $auths = $authModel->getSonsAuth($oldAuth); 

        //渲染模板
        return $this->fetch('',[
            'auths' => $auths
        ]);
    }

}