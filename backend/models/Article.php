<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id 文章主键ID
 * @property string $title 文章的标题
 * @property int $sort 文章的排序
 * @property string $intro 文章得分简介
 * @property int $cate_id 分类的ID
 * @property int $created_at 文章创建的时间
 * @property int $updated_at 文章更新的时间
 */
class Article extends \yii\db\ActiveRecord
{  public function behaviors()
      {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                      // if you're using datetime instead of UNIX timestamp:
                      // 'value' => new Expression('NOW()'),
                ],
            ];
      }
      public static $status = ['下线','上线'];
//      书写规则
      public function rules()
      {
            return [
                [['title','sort','intro','cate_id','status'],'required'],
                  [['title'],'unique']
            ];
      }
      public function attributeLabels()
      {
            return [
                'title'=>'文章的标题',
                  'intro'=>'文章的简介',
                  'sort'=>'文章的排序',
                  'cate_id'=>'分类的ID',
                  'status'=>'文章的状态'
            ];
      }
      public function getCate(){
            return $this->hasOne(Article_cate::className(),['id'=>"cate_id"]);
      }
}
