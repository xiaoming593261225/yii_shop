<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $parent_id 父级ID
 * @property int $lft 左值
 * @property int $rgt 右值
 * @property int $depth 深度
 * @property string $intro 简介
 * @property int $tree 树
 */
class Category extends \yii\db\ActiveRecord
{
      public function behaviors() {
            return [
                'tree' => [
                    'class' => NestedSetsBehavior::className(),
                       'treeAttribute' => 'tree',
                       'leftAttribute' => 'lft',
                       'rightAttribute' => 'rgt',
                       'depthAttribute' => 'depth',
                ],
            ];
      }

      public function transactions()
      {
            return [
                self::SCENARIO_DEFAULT => self::OP_ALL,
            ];
      }

      public static function find()
      {
            return new MenuQuery(get_called_class());
      }
//      书写category的规则
    public function rules()
    {
        return [
            [['name','parent_id'], 'required'],
              [['intro'],'safe']
        ];
    }

    /**
     * 书写label的名称值
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'parent_id' => '父级ID',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '深度',
            'intro' => '简介',
            'tree' => '树',
        ];
    }

    public function getNameText(){
          return str_repeat("-",$this->depth*4).$this->name;
    }
}
