<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $name 收货人姓名
 * @property string $phone 电话
 * @property string $province 省份
 * @property string $city 城市
 * @property string $county 区县
 * @property string $detail_address 详细地址
 * @property int $delivery_id 发货方式id
 * @property int $payment_id 支付方式的id
 * @property string $price_total 总金额
 * @property int $status status（状态 0已取消  1 待付款 2 待发货  3 已发货 4 待收货  5 完成）
 * @property string $order_sn 货号
 * @property int $create_time 创建的时间
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $payment_name
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'name' => '收货人姓名',
            'phone' => '电话',
            'province' => '省份',
            'city' => '城市',
            'county' => '区县',
            'detail_address' => '详细地址',
            'delivery_id' => '发货方式id',
            'payment_id' => '支付方式的id',
            'price_total' => '总金额',
            'status' => 'status（状态 0已取消  1 待付款 2 待发货  3 已发货 4 待收货  5 完成）',
            'order_sn' => '货号',
            'create_time' => '创建的时间',
            'delivery_name' => 'Delivery Name',
            'delivery_price' => 'Delivery Price',
            'payment_name' => 'Payment Name',
        ];
    }
}
