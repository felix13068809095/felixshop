<?php 

namespace app\admin\model;
use think\model;
class  Category extends Model{

    protected $pk = "cat_id" ;

    protected $autoWriteTimestamp = true;


    public function getSonsCat($data,$pid=0,$level=1){

        static $result = []; // 定義一個靜態數組,此數組遞歸調用只會初始化一次
 
         foreach($data as $v){
             if( $v['pid'] == $pid){
                 $v['level'] = $level;
                 //將$v 存到$result 中
                 $result[$v['cat_id']] = $v;
                 //遞歸調用自己
                 $this->getSonsCat($data ,$v['cat_id'], $level+1);
 
             }
         }        
         //返回遞歸好的結果
         return $result;  
     }
}