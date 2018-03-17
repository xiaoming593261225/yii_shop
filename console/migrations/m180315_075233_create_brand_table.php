<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m180315_075233_create_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
              'name'=>$this->string()->notNull()->comment('名称'),
              'sort'=>$this->integer()->defaultValue(100)->comment('排序'),
              'log'=>$this->string()->comment('图像'),
              'status'=>$this->integer()->defaultValue(1)->comment('状态'),
              'intro'=>$this->text()->comment('简介')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('brand');
    }
}
