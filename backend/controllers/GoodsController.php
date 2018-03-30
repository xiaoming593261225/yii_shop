<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsIntro;
use backend\models\GoodsPicture;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
      /*
       * 富文本
       */
      public function actions()
      {
            return [
                'upload' => [
                    'class' => 'kucha\ueditor\UEditorAction',
                    'config' => [
                        "imageUrlPrefix"  => "http://www.admin.com",//图片访问路径前缀

                    ]
                ]
            ];
      }
    public function actionShow()
    {

          $query = Goods::find();
          $minPrice = \Yii::$app->request->get('minPrice');
          $maxPrice = \Yii::$app->request->get('maxPrice');
          $keyword = \Yii::$app->request->get('keyword');
            if($minPrice){
                  $query->andWhere("shop_price>={$minPrice}");
            }
          if($maxPrice){
                $query->andWhere("shop_price<={$maxPrice}");
          }
          $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%' ");
//          获取数据的总的条数
          $count = $query->count();
          $page = new Pagination([
              'totalCount' => $count,
              'pageSize' => 2,
          ]);
//          查询数据
          $values = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('show',compact('values','page'));
    }
//    书写添加的方法
      public function actionAdd(){
          $goods = new Goods();
//           得到所有的分类数据
          $category = Category::find()->orderBy('tree,lft')->all();
            $category=ArrayHelper::map($category,'id','nameText');
//            得到所有的品牌数据
            $brand = Brand::find()->all();
            $brand=ArrayHelper::map($brand,'id','name');
//            商品详情
            $intro = new GoodsIntro();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $goods->load($request->post());
                  $intro->load($request->post());
                  if($goods->validate()){
//                        货号的处理
                        if(!$goods->sn){
//                              用年月日生成商品的编号
                              $snDaty = strtotime(date("Ymd"));
//                               找出当日的商品数量
                              $count = Goods::find()->where(['>','inserttime',$snDaty])->count();
                              $count+=1;
//                              赋值
                              $goods->sn=date("Ymd").$count+1;
//                              var_dump( $goods->sn);exit;

                        }
                        if($goods->save()){
//                              商品的内容
                              $intro->goods_id=$goods->id;
                              $intro->save();
                              foreach ($goods->logimg as $image){
                                    $picture = new GoodsPicture();
                                    $picture->goods_id=$goods->id;
                                    $picture->path=$image;
                                    $picture->save();
                              }
                              \Yii::$app->session->setFlash('success','添加数据成功');
                              return $this->redirect(['goods/show']);
                        }
                  }else{
                        var_dump($goods->errors);exit;
                  }
            }
          return $this->render("add",compact('goods','category','brand','intro'));
      }
//      书写编辑的方法
      public function actionEdit($id){
            $goods = Goods::findOne($id);
//           得到所有的分类数据
            $category = Category::find()->orderBy('tree,lft')->all();
            $category=ArrayHelper::map($category,'id','nameText');
//            得到所有的品牌数据
            $brand = Brand::find()->all();
            $brand=ArrayHelper::map($brand,'id','name');
//            商品详情
            $intro = GoodsIntro::findOne(['goods_id'=>$id]);
            $request = \Yii::$app->request;
            if($request->isPost){
                  $goods->load($request->post());
                  $intro->load($request->post());
                  if($goods->validate()){
//                        货号的处理
                        if(!$goods->sn){
//                              用年月日生成商品的编号
                              $snDaty = strtotime(date("Ymd"));
//                               找出当日的商品数量
                              $count = Goods::find()->where(['>','inserttime',$snDaty])->count();
                              $count+=1;
//                              赋值
                              $goods->sn=date("Ymd").$count+1;
//                              var_dump( $goods->sn);exit;

                        }
                        if($goods->save()){
//                              商品的内容
                              $intro->goods_id=$goods->id;
                              $intro->save();
                              GoodsPicture::deleteAll(['goods_id'=>$id]);
                              foreach ($goods->logimg as $image){
                                    $picture = new GoodsPicture();
                                    $picture->goods_id=$goods->id;
                                    $picture->path=$image;
                                    $picture->save();
                              }
                              \Yii::$app->session->setFlash('success','修改数据成功');
                              return $this->redirect(['goods/show']);
                        }
                  }else{
                        var_dump($goods->errors);exit;
                  }
            }
//            图片的回显与编辑处理
            $images = GoodsPicture::find()->where(['goods_id'=>$id])->asArray()->all();
            $images = array_column($images,'path');
//         var_dump($images);exit;
            $goods->logimg=$images;
            return $this->render("add",compact('goods','category','brand','intro'));
      }
//      书写删除的方法、
      public  function actionDel($id){
           $goods = Goods::findOne($id)->delete();
           $intro = GoodsIntro::findOne(['goods_id'=>$id])->delete();
           $path = GoodsPicture::deleteAll(['goods_id'=>$id]);
           if($goods && $intro && $path){
                 \Yii::$app->session->setFlash('success','删除数据成功');
                 return $this->redirect(['show']);
           }
      }
}
