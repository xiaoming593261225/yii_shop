<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\AuthAssignment;
use backend\models\AuthItem;
use common\models\LoginForm;
use yii\helpers\ArrayHelper;
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
            $admin->setScenario('add');
//            在创建管理员 角色的获取
//            $assign = new AuthAssignment();
//            $item = new AuthItem();
////            创建auth对象
//            $auth = \Yii::$app->authManager;
////            获取所有的角色
//            $pers = $auth->getRoles();
////            二维转一维数组的转
//            $persArr = ArrayHelper::map($pers,'name','name');
//            var_dump($persArr);exit;
            if($request->isPost){
                  $admin->load($request->post());
//                  $item->load($request->post());
                  if ($admin->validate()){
//                        var_dump($admin->username);exit;
                        $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);
                        $admin->auth_key=\Yii::$app->security->generateRandomString();
                        $admin->updated_at=time();
                        if($admin->save()){
//                              $assign->item_name=$item->name;
//                              $assign->user_id=$admin->id;
//                              $assign->save();
                              return $this->redirect(['/admin/login']);
                        }else{

                        }
                  }
            }
            return $this->render('add',compact('admin','persArr','item'));
      }

      public function actionEdit($id){
            $admin =Admin::findOne($id);
            $password = $admin->password_hash;
//            var_dump($password);exit;
            $admin->setScenario('edit');
            $request = \Yii::$app->request;
            $assign = new AuthAssignment();
            $item = new AuthItem();
//            创建auth对象
            $auth = \Yii::$app->authManager;
//            获取所有的角色
            $pers = $auth->getRoles();
//            二维转一维数组的转
            $persArr = ArrayHelper::map($pers,'name','name');
            if($request->isPost){
                  $admin->load($request->post());
                  $item->load($request->post());
                  if ($admin->validate()){
//                        var_dump($admin->password_hash);exit;
////                        利用三元判断选择
               $admin->password_hash=$admin->password_hash?\Yii::$app->security->generatePasswordHash($admin->password_hash):$password;
//                        var_dump($admin->password_hash);exit;
                        if($admin->save()){
                              $assign->item_name=$item->name;
                              $assign->user_id=$admin->id;
                              $assign->save();
                              return $this->redirect(['/admin/login']);
                        }
                  }
            }
            $admin->password_hash=null;
            return $this->render('edit',compact('admin','persArr','item'));
      }

      public function actionLogout(){
            \Yii::$app->user->logout();

            return $this->redirect(['/admin/login']);
      }

      public function actionDel($id){
//            var_dump(\Yii::$app->user->identity->id);
//            exit;
            if ( \Yii::$app->user->identity->id==$id) {
                  \Yii::$app->session->setFlash('danger', '不能删除当前用户');
                  return $this->redirect(['admin/show']);
            }else {
                  Admin::findOne($id)->delete();
                  \Yii::$app->session->setFlash('success', '删除成功');
                  return $this->redirect(['admin/show']);
            }

      }
}
