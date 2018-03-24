<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionShow()
    {
          $auth = \Yii::$app->authManager;
          $model = $auth->getRoles();
          return $this->render('show',compact('model'));
    }
//    角色的添加
      public function actionAdd(){
            $model = new AuthItem();
//            创建auth对象
            $auth = \Yii::$app->authManager;
//            获取取权限
            $pers = $auth->getPermissions();
            $persArr = ArrayHelper::map($pers,'name','description');
            $request = \Yii::$app->request;
            if($request->isPost){
                  $model->load($request->post());
//                  var_dump($model->name);
//                  exit;
//                  创建权限
                  $role = $auth->createRole($model->name);
//                  描述
                  $role->description=$model->description;
//                  角色入库的操作
                  if ($auth->add($role)) {
//                        判断权限的存在
                       if($model->permissions){
                             foreach ($model->permissions as $perName){
                                   $per=$auth->getPermission($perName);
//                        给角色添加权限
                                   $auth->addChild($role,$per);
                             }
                       }
                        \Yii::$app->session->setFlash('success','角色添加成功');
                        return $this->refresh();
                  }
            }
            return $this->render('add',compact('model','persArr'));
      }
//      角色的编辑
      public function actionEdit($name){
            $model =AuthItem::findOne($name);
//            创建auth对象
            $auth = \Yii::$app->authManager;
            $pers = $auth->getPermissions();
            $persArr = ArrayHelper::map($pers,'name','description');
//            得到当前角色的所有的权限
            $roleArr = $auth->getPermissionsByRole($name);
            $model->permissions=array_keys($roleArr);
            $request = \Yii::$app->request;
            if($request->isPost){
                  $model->load($request->post());
//                  var_dump($model->name);
//                  exit;
//                  创建权限
                  $role = $auth->getRole($model->name);
//                  描述
                  $role->description=$model->description;
//                更新角色
                  if ($auth->update($model->name,$role)) {
                        $auth->removeChildren($role);
//                        判断权限的存在
                        if($model->permissions){
                              foreach ($model->permissions as $perName){
                                    $per=$auth->getPermission($perName);
//                        给角色添加权限
                                    $auth->addChild($role,$per);
                              }
                        }
                        \Yii::$app->session->setFlash('success','角色编辑成功');
                        return $this->redirect(['show']);
                  }
            }
            return $this->render('edit',compact('model','persArr'));
      }
      public function actionDel($name){
            $auth = \Yii::$app->authManager;
            $per = $auth->getRole($name);
            if($auth->remove($per)){
                  \Yii::$app->session->setFlash('success','删除'.$name.'角色成功');
                  return $this->redirect(['show']);
            }
      }
//      给角色添加权限
      public function actinAdminRole($roleName,$id){
//            实例化组件对象
            $auth = \Yii::$app->authManager;
//            通过角色名找出角色对象
            $role = $auth->getRole($roleName);
            $auth->assign($role,$id);

      }
}
