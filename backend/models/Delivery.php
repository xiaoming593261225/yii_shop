<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property string $payment_name 送货的方式名称
 * @property string $freight 运费
 * @property string $standard 运费的标准型
 */
class Delivery extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_name','freight','standard'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_name' => '送货的方式名称',
            'freight' => '运费',
            'standard' => '运费的标准型',
        ];
    }
}
