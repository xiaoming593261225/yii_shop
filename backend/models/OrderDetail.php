<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property int $order_id 订单id
 * @property int $amount 商品数量
 * @property string $pricle 商品价格
 * @property resource $logo
 * @property string $goods_name
 * @property string $total_pricle
 */
class OrderDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'order_id' => '订单id',
            'amount' => '商品数量',
            'pricle' => '商品价格',
            'logo' => 'Logo',
            'goods_name' => 'Goods Name',
            'total_pricle' => 'Total Pricle',
        ];
    }
}
