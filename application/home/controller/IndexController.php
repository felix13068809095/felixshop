<?php
namespace app\home\controller;
use think\controller;
use app\home\model\Category;
use app\home\model\Goods;
class IndexController extends Controller{

    public function index(){
        /******************1.首页的导航栏数据*************/
        
        $catModel = new Category();

        // 限制最多5條
        $navCats = $catModel->getNavCat(5);
        

    	/******************2.首页的三级分类菜单**********/
    	$oldCats = $catModel->select()->toArray();
    	//两个技巧处理一下
    	//技巧1：把每个元素的主键字段cat_id作为其下标
    	$cats = [];
    	foreach($oldCats as $v){
    		$cats[ $v['cat_id'] ] = $v;
    	}
    	//技巧2：通过pid进行分组
    	$children = [];
    	foreach($oldCats as $v){
    		$children[ $v['pid'] ][] = $v['cat_id'];
        }
        
        /*******************3.完成首頁商品的推薦位商品取出***********************/

        $goodsData = new Goods();

        $crazyData = $goodsData->getTypeGoods('is_crazy',5);
        $hotData = $goodsData->getTypeGoods('is_hot',5);
        $bestData = $goodsData->getTypeGoods('is_best',5);
        $newData = $goodsData->getTypeGoods('is_new',5);





    	return $this->fetch('',[
    		'navCats' => $navCats,  
    		'cats' => $cats,
            'children' => $children,  
            'crazyData' =>$crazyData,
            'hotData' =>$hotData,
            'bestData' =>$bestData,
            'newData' =>$newData,
    	]);
    }

}
