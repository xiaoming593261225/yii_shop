<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 用户的id
 * @property string $name 收货人名称
 * @property string $province 省
 * @property string $city 市
 * @property string $county 区县
 * @property string $address 详情地址
 * @property string $phone 联系电话
 * @property int $status 状态
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['name','province','city','county','phone','address'],'required'],
              [['status'],'safe'],
            [['phone'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户的id',
            'name' => '收货人名称',
            'province' => '省',
            'city' => '市',
            'county' => '区县',
            'address' => '详情地址',
            'phone' => '联系电话',
            'status' => '状态',
        ];
    }
}
