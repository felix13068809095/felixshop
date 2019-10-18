<?php

namespace app\home\model;
use think\model;
class Category extends Model{



    protected $pk = 'cat_id';

    /**
    * [getNavCat description]
    * @param  [type] limit [description]
    * @return [type]        [description]
    */
    // 查找當前分類的子孫分類
    public function getSonsCats($data,$cat_id){
        static $result = [];
        foreach($data as $v){
            if($v['pid'] == $cat_id){
                $result[] = $v['cat_id'];

                // 遞歸調用
                $this->getSonsCats($data,$v['cat_id']);
            }
        }

        return $result;
    }

    /**
    * 獲取分類首頁導航欄數據
    * @param  [type] $data    數據庫數據
    * @param  [type] $cat_id  ID
    * @return [type]  返回對應的分類數據
    */


	//获取当前分类的祖先分类（无限极查找）
	public function getFamilyCat($data,$cat_id){
		static $result = [];
		foreach($data as $v){
			//找第一類
			//第一次循环肯定是找到本身分类
			if($v['cat_id'] == $cat_id){
				$result[] = $v;
				//递归查找
				$this->getFamilyCat($data,$v['pid']);
			}
		}
		//返回结果,把数组反转一下
		return array_reverse($result);
	}

    
    /**
     * 獲取首頁導航欄的數據
     * @param [type] $limit取出的條數
     * @return 返回對應的分類數據
     */
    public function getNavCat($limit){

        // 初始化條件 
        $where = [
            'is_show' => 1,
            'pid'  =>0
        ];
        
        return $this->where($where)->select();
    }
}