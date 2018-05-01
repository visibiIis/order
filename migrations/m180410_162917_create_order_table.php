<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180410_162917_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'table' => $this->primaryKey(),
            'description' => $this->text()->notNull(),
            'time' => $this->date(),
            'booked' => $this->boolean(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
