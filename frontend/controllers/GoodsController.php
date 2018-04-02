<?php

namespace frontend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsIntro;
use backend\models\GoodsPicture;
use frontend\components\ShopCart;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;

class GoodsController extends \yii\web\Controller
{
    public function actionShow()
    {
        return $this->render('show');
    }
    /*
     * 商品的展示
     */
    public function actionDetails($id){
//          var_dump($id);exit;
          $goods = Goods::findOne($id);
//          查找该商品的详情
          return $this->render('details',compact('goods'));
    }
    /*
     * 商品购物车的添加
     */
      public function actionAddCart($id,$amount){
//            var_dump($id,$amount);exit;
            if(\Yii::$app->user->isGuest){
////                  未登录
////                  得cookie值
//                  $getCookie = \Yii::$app->request->cookies;
//                  $cart = $getCookie->getValue('cart',[]);
//                  if (array_key_exists($id,$cart)) {
//                        $cart[$id]+=$amount;
//                  }else{
//                        $cart[$id]=(int)$amount;
//                  }
////                 设置cookie对象
//                  $setcookie = \Yii::$app->response->cookies;
////                  创建一个cookie对象
//                  $cookie = new Cookie([
//                      'name'=>'cart',
//                        'value' => $cart,
//                        'expire' => time()+3600*24*30*12,
//                  ]);
////                  添加cookie
//                  $setcookie->add($cookie);
//                 调用shopcart类
                  $cart = new ShopCart();
                  $cart->add($id,$amount)->save();
            }else{
//                        已登录 数据库
                  $cart=Cart::find()->where(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id])->one();
                 if($cart){
                       $cart->amount+=$amount;
                 }else{
                       $cart=new Cart();
                        $cart->user_id=\Yii::$app->user->id;
                        $cart->amount=$amount;
                        $cart->goods_id=$id;
                 }
                  $cart->save();
            }
            return $this->redirect(['goods/cart-list']);
      }

      public function actionCartList(){
            if(\Yii::$app->user->isGuest){
//                  未登录
                  $cart = \Yii::$app->request->cookies->getValue('cart',[]);
//                  得到所有的商品
                  $goodsID=array_keys($cart);
                  $goods = Goods::find()->where(['in','id',$goodsID])->all();
//                  var_dump($goods);exit;
            }else{
                  $user_id = \Yii::$app->user->id;
                  $cart_content = Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
                  $cart=ArrayHelper::map($cart_content,'goods_id','amount');
                  $goodsID=array_keys($cart);
                  $goods = Goods::find()->where(['in','id',$goodsID])->all();
//                  var_dump($goods);exit;
            }
            return $this->render('list',compact('goods','cart'));
      }
      /*
       * 修改
       */
      public function actionUpdateCart($id,$amount){
            if(\Yii::$app->user->isGuest){
////                  取出cookie中的值
//                  $cart = \Yii::$app->request->cookies->getValue('cart',[]);
////                  修改对应的数据
//                  $cart[$id]=$amount;
////                  设置cookie对象
//                  $setcookie = \Yii::$app->response->cookies;
////                  创建一个cookie对象
//                  $cookie = new Cookie([
//                      'name'=>'cart',
//                      'value' => $cart,
//                      'expire' => time()+3600*24*30*12,
//                  ]);
////                  添加cookie
//                  $setcookie->add($cookie);
                  (new ShopCart())->upload($id,$amount)->save();
            }else{
                  $user_id = \Yii::$app->user->id;
                  $cart = Cart::findOne(['user_id'=>$user_id,'goods_id'=>$id]);
                  $cart->amount= $amount;
                  $cart->save();
            }
      }
      /*
       * 删除
       */
      public function actionDelCart($id){
            if(\Yii::$app->user->isGuest){
////                  取出cookie中的值
//                  $cart = \Yii::$app->request->cookies->getValue('cart',[]);
//                  unset($cart[$id]);
////                  设置cookie对象
//                  $setcookie = \Yii::$app->response->cookies;
////                  创建一个cookie对象
//                  $cookie = new Cookie([
//                      'name'=>'cart',
//                      'value' => $cart
//                  ]);
////                  添加cookie
//                  $setcookie->add($cookie);
                  (new ShopCart())->del($id)->save();
                  return Json::encode([
                      'status'=>1,
                        'msg'=>'删除成功',
                  ]);
            }else{
//                  数据库
                  $cart = Cart::findOne(['user_id'=>\Yii::$app->user->id,'goods_id'=>$id])->delete();
                  if ($cart) {
                        return Json::encode([
                            'status'=>1,
                            'msg'=>'删除成功',
                        ]);
                  };

            }
      }
}


