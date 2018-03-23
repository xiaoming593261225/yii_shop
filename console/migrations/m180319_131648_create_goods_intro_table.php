<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m180319_131648_create_goods_intro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_intro', [
            'id' => $this->primaryKey(),
              'goods_id'=>$this->integer()->comment("商品的ID"),
              'content'=>$this->string()->comment("商品的描述")
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_intro');
    }
}
