<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16
 * Time: 21:08
 */

namespace backend\controllers;


use backend\models\Article_cate;
use yii\web\Controller;

class ArticleCateController extends Controller
{
      public function actionShow(){
//            获取分类的所有数据
            $values = Article_cate::find()->all();
//            加载分类的视图并传递数据
            return $this->render('list',compact('values'));
      }
//      分类列表的添加
      public function actionAdd(){
//            实例化一个对象
            $model = new Article_cate();
//            判断文件的post提交方式
            $request = \Yii::$app->request;
            if($request->isPost){
//                  绑定数据
                  $model->load($request->post());
//                  后台验证
                  if($model->validate()){
//                        保存数据
                        if($model->save(false)){
//                              提示
                              \Yii::$app->session->setFlash('success','分类添加成功');
//                             返回
                              return $this->redirect(['show']);
                        }
                  }else{
//                        打印错误
//                        var_dump($model->errors);exit;
                  }
            }
//            加载添加的视图
             return  $this->render('add',compact('model'));
      }
//      分类列表的编辑
      public function actionEdit($id){
            $model = Article_cate::findOne($id);
//            判断文件的post提交方式
            $request = \Yii::$app->request;
            if($request->isPost){
//                  绑定数据
                  $model->load($request->post());
//                  后台验证
                  if($model->validate()){
//                        保存数据
                        if($model->save(false)){
//                              提示
                              \Yii::$app->session->setFlash('success','分类添加成功');
//                             返回
                              return $this->redirect(['show']);
                        }
                  }else{
//                        打印错误
//                        var_dump($model->errors);exit;
                  }
            }
//            加载添加的视图
            return  $this->render('add',compact('model'));
      }
//      分类列表的删除
      public function actionDel($id){
            if (Article_cate::findOne($id)->delete()) {
                  \Yii::$app->session->setFlash('success','删除数据成功');
//                  返回
                  return $this->redirect(['show']);
            }
      }
}