<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31
 * Time: 11:50
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
      private $cart;
//    构造函数
      public function __construct(array $config = [])
      {
            $getCookie = \Yii::$app->request->cookies;
            $this->cart = $getCookie->getValue('cart',[]);
            parent::__construct($config);
      }
      /**
       * 添加
       */
      public function add($id,$amount){
            if (array_key_exists($id,$this->cart)) {
                  $this->cart[$id]+=$amount;
            }else{
                  $this->cart[$id]=(int)$amount;
            }
            return $this;
      }

      public function save(){
            //                 设置cookie对象
            $setcookie = \Yii::$app->response->cookies;
//                  创建一个cookie对象
            $cookie = new Cookie([
                'name'=>'cart',
                'value' => $this->cart,
                'expire' => time()+3600*24*30*12,
            ]);
//                  添加cookie
            $setcookie->add($cookie);
      }
//      查
      public function get(){
            return  $this->cart;
      }
//      编辑
      public function upload($id,$amount){
//                  修改对应的数据
            $this->cart[$id]=$amount;
            return $this;
      }

//      删除
      public function del($id){
            unset($this->cart[$id]);
            return $this;
      }
//      数据的同步
      public function dbSyn(){
//            取出cookie中的数据
//            将数据存入数据库中
           foreach ($this->cart as $key=>$value){
                 $cartDb = Cart::findOne(['goods_id'=>$key,'user_id'=>\Yii::$app->user->id]);
//                 判断  如果有该商品进行累加
                 if($cartDb){
                       $cartDb->amount+=$value;
                 }else{
                       $cartDb = new Cart();
                       $cartDb->user_id=\Yii::$app->user->id;
                        $cartDb->goods_id=$key;
                        $cartDb->amount=$value;
                 }
                 $cartDb->save();
           }
           return $this;
      }

//      清空cookie中的值
      public function flush(){
            $this->cart=[];
            return $this;
      }
}