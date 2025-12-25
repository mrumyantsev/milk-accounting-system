<?php

use yii\db\Migration;

class m251118_095732_create_tanks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tanks}}', [
            'id' => $this->primaryKey(),
            'quantity' => $this->integer()->notNull()->defaultValue(0),
            'capacity' => $this->integer()->notNull()->defaultValue(300),
        ], $tableOptions);

        $this->batchInsert('{{%tanks}}', ['id', 'quantity', 'capacity'], [
            [1, 0, 300],
            [2, 0, 300],
            [3, 0, 300],
            [4, 0, 300],
            [5, 0, 300],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tanks}}');
    }
}
