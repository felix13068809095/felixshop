<?PHP 

namespace app\home\controller;
use think\controller;
use app\home\model\Goods;
use app\home\model\Category;
class GoodsController extends Controller{

    public function detail(){
        /********1.麵包導航欄******************/
        // 接收參數
        $goods_id = input('goods_id');
        // 取出當前商品詳細
        $GoodModel = new Goods();
        $GoodData = $GoodModel->find($goods_id);
        $cat_id = $GoodData['cat_id'];

        // 獲取當前商品的子孫
        $CatModel = new Category();
        $oldCats = $CatModel->select()->toArray();
        $sons = $CatModel->getFamilyCat($oldCats,$cat_id);

        /***********2.商品畫廊***********************/
        $GoodData['goods_img'] = json_encode($GoodData['goods_img']);
        $GoodData['goods_middle'] = json_encode($GoodData['goods_middle']);
        $GoodData['goods_thumb'] = json_encode($GoodData['goods_thumb']);


        // 渲染模板
        return $this->fetch('',[
            'sons' => $sons,
            'GoodData' =>$GoodData
        ]);
    }

}