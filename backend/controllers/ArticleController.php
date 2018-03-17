<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16
 * Time: 22:07
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\Article_cate;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ArticleController extends Controller
{
//      书写加载文章表的方法
      public function actionShow(){
//            获取文章表的所有数据
            $values = Article::find()->all();
            return $this->render('list',compact('values'));
      }
//      书写添加文章的方法
      public function actionAdd(){
//            实例化一个添加的对象
            $model = new Article();
//            获取分类的数据
            $cates = Article_cate::find()->all();
//            数组的转换
            $cateArr = ArrayHelper::map($cates,'id','name');
//            添加数据
            $request = \Yii::$app->request;
//            判断
            if($request->isPost){
//                  绑定数据
                  $model->load($request->post());
//                  后台的验证
                  if($model->validate()){
//                        保存数据
                        if ($model->save(false)) {
                              \Yii::$app->session->setFlash('success','添加数据成功');
                              return $this->redirect(['show']);
                        }
                  }else{
//                        打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//            加载添加的视图
            return $this->render('add',compact('model','cateArr'));
      }
//      书写编辑文章的方法
      public function actionEdit($id){
            $model=Article::findOne($id);
//            获取分类的数据
            $cates = Article_cate::find()->all();
//            数组的转换
            $cateArr = ArrayHelper::map($cates,'id','name');
//            添加数据
            $request = \Yii::$app->request;
//            判断
            if($request->isPost){
//                  绑定数据
                  $model->load($request->post());
//                  后台的验证
                  if($model->validate()){
//                        保存数据
                        if ($model->save(false)) {
                              \Yii::$app->session->setFlash('success','添加数据成功');
                              return $this->redirect(['show']);
                        }
                  }else{
//                        打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//            加载添加的视图
            return $this->render('add',compact('model','cateArr'));
      }
//      书写删除文章的方法
      public function actionDel($id){
            if (Article::findOne($id)->delete()) {
                  \Yii::$app->session->setFlash('success','删除数据成功');
                  return $this->redirect(['show']);
            }
      }
}