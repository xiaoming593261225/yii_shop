<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180319_130137_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
              'name'=>$this->string()->comment("名称"),
              'sn'=>$this->integer()->comment("货号"),
              'logo'=>$this->string()->comment("商品的图片"),
              'goods_category_id'=>$this->integer()->comment("商品分类的ID"),
              'brand_id'=>$this->integer()->comment("品牌的ID"),
              'market_price'=>$this->decimal()->comment("市场价格"),
              'shop_price'=>$this->decimal()->comment("本店价格"),
              'stock'=>$this->integer()->comment("库存"),
              'is_on_sale'=>$this->integer()->comment("是否上架"),
              'sort'=>$this->integer()->comment("排序"),
              'inserttime'=>$this->integer()->comment("商品录入的时间")
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods');
    }
}
