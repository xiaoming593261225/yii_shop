<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id 主键
 * @property int $goods_id 商品id
 * @property string $amount 数量
 * @property int $user_id 用户id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'user_id','amount'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'goods_id' => '商品id',
            'amount' => '数量',
            'user_id' => '用户id',
        ];
    }
}
