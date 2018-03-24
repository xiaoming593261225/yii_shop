<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionShow()
    {
         $auth = \Yii::$app->authManager;
         $model = $auth->getPermissions();
        return $this->render('show',compact('model'));
    }
//    权限的添加
    public function actionAdd(){
          $model = new AuthItem();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $model->load($request->post());
//                  var_dump($model->name);
//                  exit;
//                  创建auth对象
                  $auth = \Yii::$app->authManager;
//                  创建权限
                  $perm = $auth->createPermission($model->name);
//                  描述
                  $perm->description=$model->description;
//                  入库的操作
                  if ($auth->add($perm)) {
                        \Yii::$app->session->setFlash('success','权限添加成功');
                        return $this->refresh();
                  }
            }
          return $this->render('add',compact('model'));
    }
//    权限的编辑
      public function actionEdit($name){
            $model =AuthItem::findOne($name);
            $request = \Yii::$app->request;
            if($request->isPost){
                  $model->load($request->post());
//                  var_dump($model->name);
//                  exit;
//                  创建auth对象
                  $auth = \Yii::$app->authManager;
//                  创建权限
                  $perm = $auth->createPermission($model->name);
//                  描述
                  $perm->description=$model->description;
//                  入库的操作
                  if ($auth->add($perm)) {
                        \Yii::$app->session->setFlash('success','权限编辑成功');
                        return $this->refresh();
                  }
            }
            return $this->render('add',compact('model'));
      }
//    权限的删除
      public function actionDel($name){
            if (AuthItem::findOne($name)->delete()) {
                  \Yii::$app->session->setFlash('success','删除权限成功');
                  return $this->redirect(['show']);
            }
      }
}