<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_picture".
 *
 * @property int $id
 * @property int $goods_id 商品的ID
 * @property string $path 图片的地址
 */
class GoodsPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品的ID',
            'path' => '图片的地址',
        ];
    }
}
