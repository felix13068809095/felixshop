<?php

namespace app\home\controller;
use think\controller;
use app\home\model\Category;
use app\home\model\Goods;
class CategoryController extends Controller{

    public function index(){
        /***********1.麵包導航欄*****************/
        // 接收參數
        $cat_id = input('cat_id');
        // 調用模型
        $CatsModel = new Category();
        $oldCats = $CatsModel->select()->toArray();
        // 獲取麵包導航欄數據
        $familyCats = $CatsModel->getFamilyCat($oldCats,$cat_id);

        /************2.列表頁左邊菜單欄**********************/
        //1.技巧一
        $cats = [];
        foreach($oldCats as $v){
            $cats[$v['cat_id']] = $v;
        }
        // 2.技巧二
        $children = [];
        foreach($oldCats as $v){
            $children[$v['pid']][] = $v['cat_id'];
        }

        /**************3.獲取當前分類及子孫分類商品**************************/
        // 獲取當前分類的子孫分類
        $sons = $CatsModel->getSonsCats($oldCats,$cat_id);
        //將當前的分類加入合集
        $sons[] = (int)$cat_id;
        // 定義查詢子孫分類的商品條件
        $where = [
            'is_sale'   => 1,
            'is_delete' => 0,
            'cat_id'    =>['in',$sons]
        ];
        $goodData = Goods::where($where)->select();
      
        // 渲染模板
        return $this->fetch('',[
            'familyCats' => $familyCats,
            'cats' =>$cats,
            'children' =>$children,
            'goodData' =>$goodData
        ]);
    }
}