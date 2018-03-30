<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $sn 货号
 * @property string $logo 商品的图片
 * @property int $goods_category_id 商品分类的ID
 * @property int $brand_id 品牌的ID
 * @property string $market_price 市场价格
 * @property string $shop_price 本店价格
 * @property int $stock 库存
 * @property int $is_on_sale 是否上架
 * @property int $sort 排序
 * @property int $inserttime 商品录入的时间
 */
class Goods extends \yii\db\ActiveRecord
{
      public function behaviors()
      {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['inserttime'],
//                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                      // if you're using datetime instead of UNIX timestamp:
                      // 'value' => new Expression('NOW()'),
                ],
            ];
      }
    /**
     * @inheritdoc
     */
    public $logimg;
    public static $stock = ['下架','上架'];
    public function rules()
    {
        return [
           [['name','market_price','shop_price','logimg','stock','logo','goods_category_id',
               'brand_id','sort','is_on_sale'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'logo' => '商品的图片',
            'goods_category_id' => '商品分类的ID',
            'brand_id' => '品牌的ID',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'sort' => '排序',
              'logimg'=>'多图上传',
            'inserttime' => '商品录入的时间',
        ];
    }
    public function getBrand(){
          return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    public function getCate(){
          return $this->hasOne(Category::className(),['id'=>'goods_category_id']);
    }
//    商品的图片
    public function getImgs(){
          return $this->hasMany(GoodsPicture::className(),['goods_id'=>'id']);
    }
//    商品的内容
      public function getContent(){
          return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
      }
}
