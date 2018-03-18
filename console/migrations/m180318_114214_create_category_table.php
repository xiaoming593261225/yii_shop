<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180318_114214_create_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment("名称"),
            'parent_id' => $this->integer()->notNull()->comment("父级ID"),
            'lft' => $this->integer()->notNull()->comment("左值"),
            'rgt' => $this->integer()->notNull()->comment("右值"),
            'depth' => $this->integer()->notNull()->comment("深度"),
            'intro' => $this->string()->comment("简介"),
            'tree' => $this->integer()->notNull()->comment("树"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
