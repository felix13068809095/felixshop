<?php

namespace app\admin\controller;
use think\controller;
use app\admin\Model\Category;
class CategoryController extends CommonController{

    public function index(){
        
        $cateModel = new Category();

        // $catedate = $cateModel->alias('t1')
        //     ->field('t1.* ,t2.cat_name as pid_name')
        //     ->join('sh_category t2','t1.pid = t2.cat_name','left')
        //     ->select();

 
        $oldCats = $cateModel->select()->toArray();
        $catedate = $cateModel->getSonsCat($oldCats);    

        return $this->fetch('',[
            'catedate' =>$catedate
        ]);
    }

    public function add(){
        if(request()->isPost()){
            $postDate = input('post.');

            $result = $this->validate($postDate,'category.add',[],true);

            if($result!==true){
                $this->error(implode(',',$result));
            }

            $catModel = new Category;

            if($catModel->save($postDate)){
                $this->success('添加類型成功',url('/admim/category/index'));
            }else{
                $this->error('添加類型失敗');
            }
        }

        $catModel = new Category();

        $oldcats = $catModel->select();

        $cateDate =$catModel->getSonsCat($oldcats);

        return $this->fetch('',[
            'cateDate'=>$cateDate
        ]);
    }
}