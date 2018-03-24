<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
      public function behaviors()
      {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        self::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                      // if you're using datetime instead of UNIX timestamp:
                      // 'value' => new Expression('NOW()'),
                ],
            ];
      }


    /**
     * @inheritdoc
     */
    public $permissions;
    public function rules()
    {
        return [
            [['name'],'required'],
            [['name'], 'unique'],
              [['description','permissions'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'name' => '名称',
            'description' => '描述',
              'permissions'=>'权限列表'
        ];
    }
}
