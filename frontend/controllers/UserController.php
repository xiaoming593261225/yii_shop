<?php

namespace frontend\controllers;

use frontend\components\ShopCart;
use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
      public function actions()
      {
            return [
                'code' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                      'minLength' => 4,
                      'maxLength' => 4,
                ],
            ];
      }

//    public function actionShow(){
//          $values = User::find()->all();
//        return $this->render('show',compact('values'));
//    }

//    注册的页面
      public function actionReg(){
            $user = new User();
          $request = \Yii::$app->request;
            if ($request->isPost) {
//                  exit('1111');
//                  var_dump($user);
                  $user->load($request->post());
//                  var_dump($user);exit;
//                  后台的验证
                  if($user->validate()){
//                              令牌与密码的处理
                        $user->auth_key=\Yii::$app->security->generateRandomString();
                        $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
//                        保存数据
//                        var_dump($user);exit;
                        if ($user->save(false)) {
                           $result=[
                               'status'=>1,
                                 'msg'=>'注册成功',
                                 'data'=>"",
                           ];
                           return Json::encode($result);
                        }
                  }else{
                        $result=[
                            'status'=>0,
                            'msg'=>'注册失败',
                            'data'=>$user->errors,
                        ];
                        return Json::encode($result);
//                        var_dump($user->errors);exit;
                  }
            }
          return $this->render('reg');
      }

//      手机号的验证
      public function actionSendSms($phone){
//            生成一个随机的四位数的验证码
            $code = rand(100000,999999);
//            配置文件的处理
            $config = [
                'access_key' => 'LTAIVT7sbzyaWKPO',
                'access_secret' => 'G8NVvNejkHTwqkwSdmaSIWUwBVqUFY',
                'sign_name' => '明明',
            ];
            $aliSms = new AliSms(); //创建一个短信发送的对象
            $response = $aliSms->sendSms($phone, 'SMS_128651055', ['code'=> $code], $config);
//                  var_dump($phone);exit;
            if($response->Message==="OK"){
                  //            存入session
                  \Yii::$app->session->set("tel_".$phone,$code);
                  return $code;
            }else{
                  var_dump($response->Message);
            }
      }

//      登录的制作 用户名 密码的验证 登录的ip 时间
      public function actionLogin(){
            $admin = new LoginForm();
            $request = \Yii::$app->request;
            if($request->isPost){
                   $admin->load($request->post());
                  if ($admin->validate()) {
//                  return $admin->username;
                        $user = User::findOne(['username'=>$admin->username,'status'=>1]);
                        if ($user) {
//                                    密码的验证
                              if (\Yii::$app->security->validatePassword($admin->password, $user->password_hash)) {
                                    \Yii::$app->user->login($user,$admin->reMessage?3600*24*7:0);
                                    $user->login_time=time();
                                    $user->login_ip=ip2long(\Yii::$app->request->userIP);
//                                    数据的同步
                                    (new ShopCart())->dbSyn()->flush()->save();
                                    if ($user->save(false)) {
                                          $result=[
                                              'status'=>1,
                                              'msg'=>'登录成功',
                                              'data'=>"",
                                          ];
                                          return Json::encode($result);
                                    }
                              }else{
                                    $result=[
                                        'status'=>0,
                                        'msg'=>'密码错误！',
                                        'data'=>[
                                            "password"=>["密码错误"]
                                        ],
                                    ];
                                    return Json::encode($result);
                              }
                        }else{
                              $result=[
                                  'status'=>-1,
                                  'msg'=>'用户名错误!',
                                  'data'=>[
                                      "username"=>["用户名错误"]
                                  ],
                              ];
                              return Json::encode($result);
                        }
                  }else{
                        $result=[

                            'status'=>-2,
                            'msg'=>'验证码，错误',
                            'data'=>$admin->errors,
                        ];
                        return Json::encode($result);
                  }
            }
            return $this->render('login');
      }
//      注销的制作
      public function actionLogout(){
            \Yii::$app->user->logout();

            return $this->redirect(['/user/login']);
      }
}
