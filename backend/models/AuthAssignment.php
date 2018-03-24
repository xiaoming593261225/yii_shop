<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }
}
