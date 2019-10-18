<?php

namespace app\home\model;
use think\model;
class Goods extends Model{

    protected $pk = 'goods_id';


    /**
    * 取出指定類型商品
    * @param  [type] $type 商品類型
    * @return [type] 返回數據
    */
    public function getTypeGoods($type,$limit){

        // 定義初始化查詢的條件
        $where = [
            'is_sale'  => 1 ,
            'is_delete' => 0
        ];

        switch($type){
            case 'is_crazy':
                // 取出最低價格幾個($limit),根據價格升序排列
                return $this->where($where)->order('goods_price  asc')->limit($limit)->select();
                break;
            
            default:
                // is_hot,is_new,is_best
                $where[ $type ] = 1;
                return $this->where($where)->order('goods_price  asc')->limit($limit)->select();
        }
    }
}