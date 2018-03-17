<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $sort 排序
 * @property string $log 图像
 * @property int $status 状态
 * @property string $intro 简介
 */
class Brand extends \yii\db\ActiveRecord
{
//      添加状态的属性
      public static $status=['在线','下线'];
//      设置图像的属性
//      public $imgLog;
//      验证码的属性
//      public $code;
     /**
      * 规则的设置
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','status','intro','sort','log'], 'required'],
//              [['imgLog'],'image','skipOnEmpty' => true,'extensions' => 'jpg,png,jif'],
              [['status'],'safe'],
//              [['code'],'captcha']
        ];
    }

    /**
     * labels的名称设置
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sort' => '排序',
            'log' => '图像',
            'status' => '状态',
            'intro' => '简介',
//              'imgLog'=>'图片',
              'code'=>'验证码'
        ];
    }
}
