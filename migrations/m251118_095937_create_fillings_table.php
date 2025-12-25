<?php

use yii\db\Migration;

class m251118_095937_create_fillings_table extends Migration
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

        $this->createTable('{{%fillings}}', [
            'id' => $this->primaryKey(),
            'filled_by' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'became' => $this->integer(),
            'tank_id' => $this->integer(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_fillings_tanks',
            '{{%fillings}}',
            'tank_id',
            '{{%tanks}}',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_fillings_tanks',
            '{{%fillings}}',
        );

        $this->dropTable('{{%fillings}}');
    }
}
