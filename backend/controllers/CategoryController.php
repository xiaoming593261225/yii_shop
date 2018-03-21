<?php
namespace backend\controllers;
use backend\models\Category;
use yii\data\ActiveDataProvider;

class CategoryController extends \yii\web\Controller
{
//      书写显示的方法
    public function actionShow()
    {
          $query = Category::find();
          $dataProvider = new ActiveDataProvider([
              'query'=>$query,
                'pagination'=>false
          ]);
        return $this->render('show',compact("dataProvider"));
    }
//    书写添加的方法
    public function actionAdd(){
          $category = new Category();
//          查出所有的分类
          $cate = Category::find()->asArray()->all();
          $cate[]=["id"=>0,"name"=>"一级菜单","parent_id"=>0];
//          转为json对象
          $cateJson =json_encode($cate);
//          var_dump($cateJson);exit;
          $request = \Yii::$app->request;
          if($request->isPost){
                $category->load($request->post());
                if($category->validate()){
                        if($category->parent_id==0){
//                              一级分类的做法
                              $category->makeRoot();
                              \Yii::$app->session->setFlash('success','创建一级分类:'.$category->name."成功");
                              return $this->redirect(['category/show']);
                        }else{
//                              二级的分类
                              $cateParent = Category::findOne($category->parent_id);
                              $category->prependTo($cateParent);
                              \Yii::$app->session->setFlash('success','创建二级分类');
                              return $this->redirect(['category/show']);
                        }
                }else{
                      var_dump($category->errors);exit;
                }
          }
          return $this->render("add",compact("category",'cateJson'));
    }
//    书写编辑的方法
      public function actionUpdate($id){
//          var_dump($id);exit;
            $category =Category::findOne($id);
//          查出所有的分类
            $cate = Category::find()->asArray()->all();
            $cate[]=["name"=>"一级菜单","parent_id"=>0];
//          转为json对象
            $cateJson =json_encode($cate);
//          var_dump($cateJson);exit;
            $request = \Yii::$app->request;
            if($request->isPost){
                  $category->load($request->post());
                  if($category->validate()){
                        if($category->parent_id==0){
//                              一级分类的做法
                              $category->save();
                              \Yii::$app->session->setFlash('success','创建一级分类:'.$category->name."成功");
                              return $this->redirect(['category/show']);
                        }else{
//                              二级的分类
                              $cateParent = Category::findOne($category->parent_id);
                              $category->prependTo($cateParent);
                              \Yii::$app->session->setFlash('success','创建二级分类');
                              return $this->redirect(['category/show']);
                        }
                  }else{
                        var_dump($category->errors);exit;
                  }
            }
            return $this->render("add",compact("category",'cateJson'));
      }
//      书写删除的方法
      public function actionDelete($id){
//            var_dump($id);
//            exit;
            if (Category::findOne($id)->delete()) {
                  \Yii::$app->session->setFlash("success",'删除数据成功');
                  return $this->redirect(['category/show']);
            }
      }
}
