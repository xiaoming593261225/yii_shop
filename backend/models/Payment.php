<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id 主键
 * @property string $payment_name 名称
 * @property string $content 简介
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_name','content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'payment_name' => '名称',
            'content' => '简介',
        ];
    }
}
