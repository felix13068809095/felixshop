<?php 
namespace app\admin\controller;
use think\controller;
use app\admin\model\Type;
use app\admin\model\Attribute;
class AttributeController extends CommonController{
    public function del(){
        $attr_id = input('attr_id');

        if(Attribute::destroy($attr_id)){
            $this->success('刪除成功',url('/admin/attribute/index'));
        }else{
            $this->error('刪除失敗');
        }
    }

    public function upd(){
        if(request()->isPost()){
            $postDate = input('post.');


            if($postDate['attr_input_type'] == "0"){
                $result = $this->validate($postDate,'attribute.special',[],true);
            }else{
                $result = $this->validate($postDate,'attribute.upd',[],true);
            }
            

            if($result!==true){
                $this->error(impolde(',',$result));
            }

            $attributeModel =  new Attribute;

            if($attributeModel->update($postDate)){
                $this->success('更新成功',url('/admin/attribute/index'));
            }else{
                $this->error('更新失敗');
            }
        }


        $attr_id = input('attr_id');

        $typeDate = Type::select();
        
        $attributes = Attribute::find($attr_id);

        return $this->fetch('',[
            "attributes" =>$attributes,
            "typeDate" =>$typeDate
        ]);
    }

    public function index(){

        $attributes = Attribute::alias('t1')
            ->field('t1.*,t2.type_name')
            ->join('sh_type t2','t1.type_id =t2.type_id','left')
            ->select();
        // halt($attributes);
        return  $this->fetch('',[
            'attributes' =>$attributes
        ]);
    }
    
    public function add(){
        if(request()->isPost()){
            $postDate = input('post.');

            if($postDate['attr_input_type'] == "0"){
                $result = $this->validate($postDate,'Attribute.special',[],true);
            }else{
                $result = $this->validate($postDate,'Attribute.add',[],true);
            }

            if($result !== true){
                $this->error(implode(',',$result));
            }

            $attrModel = new Attribute();

            if($attrModel->save($postDate)){
                $this->success('添加商品屬性成功',url('/admin/attribute/index'));
            }else{
                $this->error('添加商品屬性失敗');
            }

        }

        $typeDate = Type::select();

        return $this->fetch('',[
            'typeDate' => $typeDate
        ]);
    }

}