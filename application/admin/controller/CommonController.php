<?php 

namespace app\admin\controller;
use think\controller;
class CommonController extends Controller{

    public function _initialize(){

        if(!session('user_id')){
            $this->redirect('/admin/public/login');
        }else{

            // 權限防翻墻
            // 獲取當前頁面的方法名和控制器名
            $now_c = strtolower(request()->controller());
            $now_a = request()->action();

            $now_all = strtolower($now_c.'/'.$now_a);

            // 判斷是否有訪問權限
            $visitor = session('visitor');

            //如果是超級管理員放行
            //首頁控制器不驗證 可放行 
            if($visitor == '*' | $now_c == 'index'){
                return;
            }

            //驗證是否有權限
            if(!in_array($now_all,$visitor)){
                $this->redirect('/admin/index/index');
            }
        }
    }
}
 