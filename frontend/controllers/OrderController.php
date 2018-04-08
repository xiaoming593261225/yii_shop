<?php

namespace frontend\controllers;

use backend\models\Delivery;
use backend\models\Goods;
use backend\models\Order;
use backend\models\OrderDetail;
use backend\models\Payment;
use frontend\models\Address;
use frontend\models\Cart;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;
use yii\helpers\Url;

class OrderController extends \yii\web\Controller
{
//      解决400的错误
      public $enableCsrfValidation=false;
    public function actionShow()
    {
          $user_id = \Yii::$app->user->id;
          $cart_content = Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
          $cart=ArrayHelper::map($cart_content,'goods_id','amount');
          $goodsID=array_keys($cart);
          $goods = Goods::find()->where(['in','id',$goodsID])->all();
          $address = Address::find(['user_id'=>\Yii::$app->user])->all();
          $deliverys =Delivery::find()->all();
          $payments =Payment::find()->all();
//          登录的验证
          if(\Yii::$app->user->isGuest){
                return $this->redirect(['/user/login','url'=>'/order/show']);
          }
                return $this->render('show',compact('address','goods','cart','deliverys','payments'));
    }
//    地址的操作
//    public function actionAddress(){
//          $address = new Address();
//          $request = \Yii::$app->request;
//          if($request->isPost){
//                $address->load($request->post());
////               后台的验证
//                if ($address->validate()) {
//                      $address->user_id=\Yii::$app->user->id;
////                        状态的操作
//                      if ($address->status!=null) {
//                            Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
//                            $address->status=1;
//                      }
//                      if ($address->save()) {
//                            $result = [
//                                'status'=>1,
//                                'msg'=>'操作地址成功',
//                                'data'=>'',
//                            ];
//                            return Json::encode($result);
//                      }
//                }else{
//                      $result = [
//                          'status'=>0,
//                          'msg'=>'操作失败',
//                          'data'=>$address->errors,
//                      ];
//                      return Json::encode($result);
//                }
//          }
//    }
//    删除
      public function actionDel($id){
            if (Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete()) {
                  return $this->redirect(['show']);
            }
      }
//      数据入库操作
      public function actionInsert(){
//            var_dump("qwreqwe");exit;
            $user_id = \Yii::$app->user->id;
            $cart_content = Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
            $cart=ArrayHelper::map($cart_content,'goods_id','amount');
            $goodsID=array_keys($cart);
            $goods = Goods::find()->where(['in','id',$goodsID])->all();
            $shopPrice = 0;
            $shopNum = 0;
            foreach ($goods as $good){
                  $shopPrice+=$good->shop_price*$cart[$good->id];
                  $shopNum+=$cart[$good->id];
            }
            $shopPrice=number_format($shopPrice,'2');
//            var_dump($shopPrice);exit;
            $request = \Yii::$app->request;
            if($request->isPost){
//                  实例对象
//                  事务的处理
                  $db = \Yii::$app->db;
                  $transaction = $db->beginTransaction();
                  try {
//                  配送方式
                        $order = new Order();
//                  var_dump($order);exit;
                        $addressId = $request->post('address');
                        $address = Address::findOne(['id'=>$addressId,'user_id'=>\Yii::$app->user->id]);
                        $deliveryId = $request->post('delivery');
                        $delivery = Delivery::findOne($deliveryId);
                        //                  配送方式
                        $paymentId = $request->post('pay');
                        $payment = Payment::findOne($paymentId);
//                  var_dump($payment);exit;
//                  赋值
                        $order->user_id=\Yii::$app->user->id;
//                  var_dump($order->user_id);exit;
                        $order->name=$address->name;
//                  var_dump($order->name);exit;
                        $order->province=$address->province;
                        $order->city=$address->city;
                        $order->county=$address->county;
                        $order->detail_address=$address->address;

                        $order->delivery_id =$deliveryId;
//                  var_dump($order->delivery_id);exit;
                        $order->delivery_name = $delivery->payment_name;
                        $order->delivery_price = $delivery->freight;

                        $order->payment_id=$paymentId;
//                  var_dump($order->payment_id);exit;
                        $order->payment_name = $payment->payment_name;
//                  var_dump($order->payment_name);exit;
                        $order->price_total = $delivery->freight+$shopPrice;
//                  var_dump($order->price_total);exit;
//                  订单的状态
                        $order->status=1;  //0 已取消 1 待支付 2 等待发货 3等待确认

//                  订单号
                        $order->order_sn=rand(1000,9999);

//                  时间
                        $order->create_time=time();
//                  var_dump($goods);exit;
//                  保存数据

                        if ($order->save()) {
                              foreach ($goods as $good){
//                              商品的库存
                                    $stockGood = Goods::findOne($good->id);
//                              判断库存
                                    if($cart[$good->id]>$stockGood->stock){
                                          throw new Exception("库存不足");
                                    }

                                    $orderDetail = new OrderDetail();
                                    $orderDetail->order_id=$order->id;
                                    $orderDetail->goods_id=$good->id;
                                    $orderDetail->goods_name=$good->name;
                                    $orderDetail->amount=$cart[$good->id];
                                    $orderDetail->logo=$good->logo;
                                    $orderDetail->pricle=$good->shop_price;
                                    $orderDetail->total_pricle=$good->shop_price*$cart[$good->id];
//                              保存数据
                                    if ($orderDetail->save()) {
//                                    减去当前商品的库存
                                          $stockGood->stock=$stockGood->stock-$cart[$good->id];
                                          $stockGood->save(false);
                                    }
                              }
                        }
                        Cart::deleteAll(['user_id'=>$user_id]);
                        // ... executing other SQL statements ...
                        $transaction->commit();  //提交事务

                        return Json::encode([
                            'status'=>1,
                            'msg'=>'订单提交成功',
                              'orderId'=>$order->id,
                        ]);

                  } catch(Exception $e) {

                        $transaction->rollBack(); //回滚

                        return Json::encode([
                            'status'=>0,
                            'msg'=>$e->getMessage()
                        ]);
                  }

            }
      }
      public function actionList($id){
            $order = Order::findOne($id);
            return $this->render('list',compact('order'));
      }
//      二维码的制作
      public function actionWeixin($id){
            $order = Order::findOne($id);
            $options =\Yii::$app->params['weixin'];
            $app = new Application($options);
            $payment = $app->payment;

      //订单详情信息

            $attributes = [
                'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
                'body'             => '小明商场',
                'detail'           => 'vivo X7',
                'out_trade_no'     => $order->order_sn,
                'total_fee'        => $order->price_total*100, // 单位：分
//                  异步请求的地址
                'notify_url'       => Url::to(['order/notify'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
               // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
                  // ...
            ];
//                  通过订单信息生成订单
            $order = new \EasyWeChat\Payment\Order($attributes);
//                  统一下单
            $result = $payment->prepare($order);
//            var_dump($result);exit;
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                 // $prepayId = $result->prepay_id;
//                  取得code——url地址
                  $qrCode = new QrCode($result->code_url);
                  header('Content-Type: '.$qrCode->getContentType());
                  echo $qrCode->writeString();
            }else{
                  var_dump($result);
            }
      }

//      建立异步通信接口
      public function actionNotify(){
            $options =\Yii::$app->params['weixin'];
            $app = new Application($options);
            $response = $app->payment->handleNotify(function($notify, $successful){
                  // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//                  $order = 查询订单($notify->out_trade_no);
                  $order = Order::findOne(['order_sn'=>$notify->out_trade_no]);
                  if (!$order) { // 如果订单不存在
                        return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                  }

                  // 如果订单存在
                  // 检查订单是否已经更新过支付状态
                  if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                        return true; // 已经支付成功了就不再更新了
                  }

                  // 用户是否支付成功
                  if ($successful) {
                        // 不是已经支付状态则修改为已经支付状态
                        //$order->paid_at = time(); // 更新支付时间为当前时间
                        $order->status = 2;  // 1 等待支付 2 已支付
                  }
                  $order->save(); // 保存订单

                  return true; // 返回处理完成
            });

            return $response;
      }

//      支付的状态通知
      public function actionStatus($id){
            $roder = Order::findOne($id);
            return Json::encode($roder);
      }

//      超时的处理
      public function actionClear(){
//            事务的处理
                  $db = \Yii::$app->db;
                  $transaction = $db->beginTransaction();
                  try {
            $orders = Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-900])->asArray()->all();
            $ordersId = array_column($orders,"id");
            var_dump($ordersId);
            Order::updateAll(['status'=>1],['in','id',$orders]);
//            库存还原
            foreach ($orders as $order){
//                  商品详情
                  $orderDetal = OrderDetail::find()->where(['order_id'=>$order['id']])->all();
//                  循环商品详情
                  foreach ($orderDetal as $value){
                        Goods::updateAllCounters(['stock'=>$value->amount],['id'=>$value->goods_id]);
                  }
            }
                        $transaction->commit();  //提交事务
                  } catch(Exception $e) {
                        $transaction->rollBack(); //回滚
                  }

      }

}
