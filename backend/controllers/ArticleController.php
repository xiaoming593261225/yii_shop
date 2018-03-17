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
use backend\models\ArticleContent;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ArticleController extends Controller
{
      public function actions()
      {
            return [
                'upload' => [
                    'class' => 'kucha\ueditor\UEditorAction',
                ]
            ];
      }
//      书写加载文章表的方法
      public function actionShow(){
            //      书写分页的方法 获取数据
            $query = Article::find();
//          获取数据的总的条数
            $count = $query->count();
            $page = new Pagination([
                'totalCount' => $count,
                'pageSize' => 1,
            ]);
//          查询数据
            $values = $query->offset($page->offset)->limit($page->limit)->all();
            return $this->render('list',compact('values','page'));
      }
//      书写添加文章的方法
      public function actionAdd(){
//            实例化一个添加的对象
            $model = new Article();
            $content = new ArticleContent();
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
                     if($model->save()){
                           $content->load($request->post());
                           if($content->validate()){
                                 $content->article_id=$model->id;
                                 if($content->save()){
                                    return $this->redirect(['show']);
                                 }
                           }
                     }
                  }else{
//                        打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//            加载添加的视图
            return $this->render('add',compact('model','cateArr','content'));
      }
//      书写编辑文章的方法
      public function actionEdit($id){
//            实例化一个添加的对象
            $model =Article::findOne($id);
            $content =ArticleContent::findOne($id);
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
                        if($model->save()){
                              $content->load($request->post());
                              if($content->validate()){
                                    $content->article_id=$model->id;
                                    if($content->save()){
                                          return $this->redirect(['show']);
                                    }
                              }
                        }
                  }else{
//                        打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//            加载添加的视图
            return $this->render('add',compact('model','cateArr','content'));
      }
//      书写删除文章的方法
      public function actionDel($id){
            if (Article::findOne($id)->delete()) {
                  \Yii::$app->session->setFlash('success','删除数据成功');
                  return $this->redirect(['show']);
            }
      }
}