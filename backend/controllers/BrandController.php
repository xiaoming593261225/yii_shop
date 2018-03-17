<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
      public function actionShow()
      {
            //      书写分页的方法 获取数据
            $query = Brand::find();
//          获取数据的总的条数
            $count = $query->count();
            $page = new Pagination([
                'totalCount' => $count,
                'pageSize' => 2,
            ]);
//          查询数据
            $brand = $query->offset($page->offset)->limit($page->limit)->all();
//          加载视图
            return $this->render('show', compact('brand', 'page'));
      }
//    品牌的添加
      public function actionAdd()
      {
//          实例化一个对象
            $model = new Brand();
            $request = \Yii::$app->request;
//          判断数据的提交方式
            if ($request->isPost) {
//                绑定数据
                  $model->load($request->post());
//                        图片的验证
////                获取图片
//                $model->imgLog=UploadedFile::getInstance($model,'imgLog');
////                var_dump($model->imgLog);
////                exit;
////                判断图片是否不为空
//                $imgPath="";
//                if($model->imgLog){
////                        重新定义图片的路径规则
//                      $imgPath="images/".rand().".".$model->imgLog->extension;
////                      将图片移动
//                      $model->imgLog->saveAs($imgPath,false);
//                }
//                后台的验证
                  if ($model->validate()) {
//                        将图片给数据库
//                      $model->log=$imgPath;
//                      保存数据
                        if ($model->save()) {
//                            提示
                              \Yii::$app->session->setFlash('success', '品牌添加成功');
//                            返回
                              return $this->redirect(['show']);
                        }
                  } else {
//                      打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//          加载视图
            return $this->render('add', compact('model'));
      }
//    品牌的编辑
      public function actionEdit($id)
      {
            $model = Brand::findOne($id);
            $request = \Yii::$app->request;
//          判断数据的提交方式
            if ($request->isPost) {
//                绑定数据
                  $model->load($request->post());
//                        图片的验证
////                获取图片
//                  $model->imgLog=UploadedFile::getInstance($model,'imgLog');
////                判断图片是否不为空
//                  $imgPath="";
//                  if($model->imgLog){
////                        重新定义图片的路径规则
//                        $imgPath="images/".rand().".".$model->imgLog->extension;
////                      将图片移动
//                        $model->imgLog->saveAs($imgPath,false);
//                  }
//                后台的验证
                  if ($model->validate()) {
//                        判断修改的图片是否有
//                        $model->log=$imgPath?:$model->log;
//                      保存数据
                        if ($model->save(false)) {
//                            提示
                              \Yii::$app->session->setFlash('success', '品牌添加成功');
//                            返回
                              return $this->redirect(['show']);
                        }
                  } else {
//                      打印错误
                        var_dump($model->errors);
                        exit;
                  }
            }
//          加载视图
            return $this->render('add', compact('model'));
      }
//      品牌的删除
      public function actionDel($id){
            if (Brand::findOne($id)->delete()) {
//                  提示
                  \Yii::$app->session->setFlash('success', '删除数据成功');
//                  页面的跳转
                  return $this->redirect(['show']);
            }
      }
//      品牌中图片的处理完善
      public function actionUpload()
      {
            switch (\Yii::$app->params['uploadType']) {
                  case "localhost":
                        //            通过Name得到上传对象的值
                        $imgLog = UploadedFile::getInstanceByName('file');
//            将临时文件移动
                        if ($imgLog !== null) {
//                  拼接图片的路径
                              $imgPath = "images/" . rand() . "." . $imgLog->extension;
//                  var_dump($imgPath);
//                  exit;
//                  保存图片到数据库
                              if ($imgLog->saveAs($imgPath, false)) {
                                    $imgLogin = [
                                        'code' => 0,
                                        'url' => "/" . $imgPath,
                                        'attachment' => $imgPath,
                                    ];
                                    return json_encode($imgLogin);
                              } else {
                                    $result = [
                                        'code' => 1,
                                        'msg' => 'error',
                                    ];
                                    return json_encode($result);
                              }
                        }
                  case "qiniu":
                        $ak = '19wzF5o5gx3-rLRYGy4hWuLXsSkSbgC01o1PnEsS'; //应用的ID
                        $sk = 'YnFp544elS2sMRjCOde11npoWNghGsscWZcxkzTi'; //密钥
                        $domain = 'http://p5o8t6bf3.bkt.clouddn.com/';  //地址
                        $bucket = '1108xiaoming'; // 空间名称
                        $zone = 'south_china'; //区域
                        $qiniu = new Qiniu($ak, $sk, $domain, $bucket, $zone);
                        $key = time();
                        $key .= strtolower(strrchr($_FILES['file']['name'], '.'));

                        $qiniu->uploadFile($_FILES['file']['tmp_name'], $key);
                        $url = $qiniu->getLink($key);
                        $imgLogin = [
                            'code' => 0,
                            'url' => $url,
                            'attachment' => $url,
                        ];
                        return json_encode($imgLogin);
            }

      }
}
