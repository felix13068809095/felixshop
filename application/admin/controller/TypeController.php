<?php 


namespace app\admin\controller;
use think\controller;
use app\admin\model\Type;
class TypeController extends CommonController{

    public function del(){

        $type_id = input('type_id');

        if(Type::destroy($type_id)){
            $this->success('刪除成功',url('/admin/type/index'));
        }else{
            $this->error('刪除失敗');
        }
    }
     
    

    public function upd(){
        if(request()->isPost()){
            $postData = input('post.');

            $result =$this->validate($postData,'Type.upd',[],true);

            if($result !== true){
                $this->error(implode(',',$result));
            }

            $typeModel = new Type();
            if($typeModel->update($postData)){
                $this->success('更新成功',url('/admin/type/index'));
            }else{
                $this->error('更新失敗');
            }
        }

        $type_id = input('type_id');

        $typeData = Type::find($type_id);
        return $this->fetch('',[
            'typeData' =>$typeData
        ]);
    }

    public function index(){

        $typeData = Type::select();

        return $this->fetch('',[
            "typeData" => $typeData
        ]);
    }

    public function add(){

        if(request()->isPost()){

            $postData = input('post.');

            
            $result = $this->validate($postData,"Type.add",[],true);

            if($result !== true){
                $this->error(implode(',',$result));
            }

            $typeModel = new Type();

            if($typeModel->save($postData)){
                $this->success('添加成功',url('/admin/type/index'));
                }else{
                    $this->error('添加失敗');
            }
        }




        return $this->fetch();
    }
}