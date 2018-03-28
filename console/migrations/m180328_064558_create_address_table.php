<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m180328_064558_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
              'user_id'=>$this->integer()->comment('用户的id'),
              'name'=>$this->string()->notNull()->comment('收货人名称'),
              'province'=>$this->string()->comment('省'),
              'city'=>$this->string()->comment('市'),
              'county'=>$this->string()->comment('区县'),
              'address'=>$this->string()->comment('详情地址'),
              'phone'=>$this->string()->comment('联系电话'),
              'status'=>$this->smallInteger()->defaultValue(0)->comment('状态')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('address');
    }
}
