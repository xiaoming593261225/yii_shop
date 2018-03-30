<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;

class IndexController extends \yii\web\Controller
{
    public function actionShow()
    {
        return $this->render('show');
    }
      /*
       * 商品的分类展示
       */
      public function actionList($id){
//            通过id得到最新的对象
            $cate = Category::findOne($id);
//            var_dump($cate);exit;
//            找最新对象的子孙对象
            $sonCate = Category::find()->where(['tree'=>$cate->tree])->andWhere(['>=','lft',$cate->lft])->andWhere
            (['<=','rgt',$cate->rgt])->asArray()->all();
//            var_dump($sonCate);exit;
            $cateIds = array_column($sonCate,'id');
//            var_dump($cateIds);exit;
//            得到当前的所有分类
            $goods = Goods::find()->where(['in','goods_category_id',$cateIds])->all();
//            var_dump($goods);exit;
          return $this->render('list',compact('goods'));
      }
}
