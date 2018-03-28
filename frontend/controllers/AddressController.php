<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
      /*
       * 地址的显示
       */
    public function actionShow()
    {
          $addresss = Address::find()->all();
        return $this->render('show',compact('addresss'));
    }
    /*
     * 地址的添加
     */
    public function actionStorage(){
//          实例化一个对象
          $address = new Address();
          $request = \Yii::$app->request;
          if($request->isPost){
                $address->load($request->post());
//               后台的验证
                if ($address->validate()) {
                        $address->user_id=\Yii::$app->user->id;
//                        状态的操作
                      if ($address->status!=null) {
                            Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
                            $address->status=1;
                      }
                      if ($address->save()) {
                            $result = [
                                'status'=>1,
                                'msg'=>'操作地址成功',
                                  'data'=>'',
                            ];
                            return Json::encode($result);
                      }
                }else{
                      $result = [
                          'status'=>0,
                          'msg'=>'操作失败',
                            'data'=>$address->errors,
                      ];
                      return Json::encode($result);
                }
          }
            return $this->render('show');
    }
    /*
     * 地址的删除
     */
      public function actionDel($id){
//            var_dump($id);
            if (Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete()) {
                  return $this->redirect(['show']);
            }
      }
}
