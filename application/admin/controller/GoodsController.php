<?php 
namespace app\admin\controller;
use think\controller;
use app\admin\model\Category;
use app\admin\model\Goods;
use app\admin\model\Type;
use app\admin\model\Attribute;
class Goodscontroller extends CommonController{


        public function del(){
            $goods_id = input('goods_id');

            if(Goods::destroy($goods_id)){
                $this->success('刪除成功',url('/admin/goods/index'));
            }else{
                $this->error('刪除失敗');
            }
        }

        public function index(){         
            
            $cateModel = new Category();
            $goodsDate = Goods::alias('t1')
                ->field('t1.*,t2.cat_name')
                ->join('sh_category t2','t1.cat_id = t2.cat_id','left')
                ->order("goods_id desc")
                ->paginate(1);
                // ->select();
            

            // 渲染模板
            return $this->fetch('',[
                'goodsDate' =>$goodsDate,
            ]);
        }

        public function add(){
            
            if(request()->isPost()){
                $postDate = input('post.');
                $result = $this->validate($postDate,'goods.add',[],true);

                if($result!==true){
                    $this->error(implode(',',$result));
                }

                //調動當前類的中的uploadImg實現文件
                $Good_Img = $this->uploadImg();
                
                if($Good_Img){
                    //把数组格式转化为json格式 原图上传数据
                    $postDate['goods_img'] = json_encode($Good_Img);

                    // 原圖上傳成功后,進行虐縮圖航船處理,中图和小图调用当前类中的方法
                    $thumb = $this->genThumb($Good_Img);

                    //講數組轉化為json格式 中圖和小圖上傳數據
                    $postDate['goods_middle'] = json_encode($thumb['goods_middle']);
                    $postDate['goods_thumb'] = json_encode($thumb['goods_thumb']);
                }

                $goodsModel = new Goods;

                if($goodsModel->save($postDate)){
                    $this->success('添加成功',url('/admin/goods/index'));
                }else{
                    $this->error('添加失敗');
                }
            }

            $cateModel = new Category();
            $typedate =Type::select();
            $oldCats = $cateModel->select()->toArray();
            $catedate = $cateModel->getSonsCat($oldCats); 

            return $this->fetch('',[
                'catedate' =>$catedate, 
                'typedate' =>$typedate
            ]);
        }

        

        public function getAttr(){

            if(request()->isAjax()){
                $type_id = input('type_id');

                $Attrdate = Attribute::where('type_id','=',$type_id)->select();

                echo json_encode($Attrdate);
            }
        }


        // 原圖保存方法
        public function uploadImg(){
            // //用途存儲圖片路徑
            $goodsImg = [];
    
            $files = request()->file('img');

            // 驗證條件
            $validate = [
                'size' => 1024*1024*100 , //100M
                'ext'  => 'jpg,jpeg,png,gif'
            ];

            //保存的文件,如果沒有就創建新的文件
            $uploadDir = "./uploads";

           // 循環圖片上傳
            foreach( $files as $file){

                $info = $file->validate($validate)->move($uploadDir);

                if($info){
                    // 上傳成功 把路徑存儲到$goodsImg數組裡面
                    $goodsImg[] = str_replace('\\','/',$info->getSaveName()) ;
                }
            }
            return $goodsImg;
        }

        // 中圖和略縮圖保存方法
        public function genThumb($goods_img){
            $goods_middle = []; //保存中圖路徑
            
            $goods_thumb  = []; //保存小圖路徑

            // 中圖 350*350 循環進行略縮圖縮放
            foreach($goods_img as $path){
                // 先將數組炸開
                $arr_path = explode('/',$path);
                // 處理原圖原路徑
                $image = \think\Image::open('./uploads/'.$arr_path[0].'/'.$arr_path[1]); 
                // 定義中圖的文件名
                $middle_path = $arr_path[0].'/middle_'.$arr_path[1];
                // 進行長寬的比例2進行縮放處理
                $image->thumb(350,350,2)->save('./uploads/'.$middle_path);
                //把中圖縮放后放在路徑裡面
                $goods_middle[] = $middle_path;
            }

            foreach($goods_img as $path){
                // 先將原圖路徑炸開
                $arr_path = explode('/',$path);
                //講原圖路徑拼接
                $image = \think\Image::open('./uploads/'.$arr_path[0].'/'.$arr_path[1]);
                // 定義小圖的文件名
                $thumb_image = $arr_path[0].'/thumb_'.$arr_path[1];
                //進行指定的小圖大小進行縮放處理 50 * 50
                $image->thumb(50*50*2)->save('./uploads/'.$thumb_image);
                // 把小圖縮放后放在路徑保存
                $goods_thumb[] =$thumb_image;
            }

            return ['goods_middle' =>$goods_middle,
                    'goods_thumb'  =>$goods_thumb        
                    ];
        }

}
