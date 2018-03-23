<?php

namespace backend\controllers;

use backend\models\Admin;
use common\models\LoginForm;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
      public function actions()
      {
            return [
                'upload' => [
                    'class' => 'kucha\ueditor\UEditorAction',
                ]
            ];
      }
    public function actionShow(){
          $values = Admin::find()->all();
        return $this->render('show',compact('values'));
    }
      public function actionLogin(){
            $model = new LoginForm();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $model->load($request->post());
                  if($model->validate()){
                        $admin = Admin::findOne(['username'=>$model->username,'status'=>1]);
//                        echo 1;exit;
                        if($admin){
                              if(\Yii::$app->security->validatePassword($model->password,$admin->password_hash)){
                                    \Yii::$app->user->login($admin);
//                                    var_dump($model->getErrors());exit;
                                    return $this->redirect(['/goods/show']);
                              }else{
                                   // echo 123223;exit;
                                    $model->addError('passsword','密码不行');
                              }
                        }else{
                              $model->addError('username','用户名不存在或禁用');
                        }
                  }else{
                        var_dump($model->errors);exit;
                  }
            }
            return $this->render('login', [ 'model' => $model,
            ]);
      }

      public function actionAdd(){
            $admin = new Admin();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $admin->load($request->post());
                  if ($admin->validate()){
//                        var_dump($admin->log);exit;
                        $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);
                        $admin->auth_key=\Yii::$app->security->generateRandomString();

                        if($admin->save()){
                              return $this->redirect(['/admin/login']);
                        }
                  }
            }
            return $this->render('add',compact('admin'));
      }

      public function actionEdit($id){
            $admin =Admin::findOne($id);
            $password = $admin->password_hash;
//            var_dump($password);exit;
            $admin->setScenario('edit');
            $request = \Yii::$app->request;
            if($request->isPost){
                  $admin->load($request->post());
                  if ($admin->validate()){
//                        var_dump($admin->password_hash);exit;
////                        利用三元判断选择
               $admin->password_hash=$admin->password_hash?\Yii::$app->security->generatePasswordHash($admin->password_hash):$password;
//                        var_dump($admin->password_hash);exit;
                        if($admin->save()){
                              return $this->redirect(['/admin/login']);
                        }
                  }
            }
            $admin->password_hash=null;
            return $this->render('add',compact('admin'));
      }

      public function actionLogout(){
            \Yii::$app->user->logout();

            return $this->redirect(['/admin/login']);
      }

      public function actionTest(){

            echo \Yii::$app->security->generatePasswordHash('1');


            var_dump(\Yii::$app->security->validatePassword('1','$2y$13$.L6fBYskFXRPrQGLt71/0ep5z4qRZWNosPb4yWYNUpcbZ.UOP3vhq'));


      }
}
