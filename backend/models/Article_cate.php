<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16
 * Time: 21:07
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article_cate extends ActiveRecord
{
//      设置分类的属性
      public static $status = ['下线','上线'];
      public function rules()
      {
            return [
                [['status','intro','sort','is_help'], 'required'],
                  [['name'],'unique']
//              [['code'],'captcha']
            ];
      }
      public function attributeLabels()
      {
            return[
                'name'=>'分类名称',
                'sort'=>'分类排序',
                'status'=>'分类状态',
                'intro'=>'分类简介',
                'is_help'=>'分类的友情',
            ];
      }
}