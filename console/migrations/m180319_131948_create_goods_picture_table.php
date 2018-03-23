<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_picture`.
 */
class m180319_131948_create_goods_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_picture', [
            'id' => $this->primaryKey(),
              'goods_id'=>$this->integer()->comment("商品的ID"),
              'path'=>$this->string()->comment("图片的地址")
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_picture');
    }
}
