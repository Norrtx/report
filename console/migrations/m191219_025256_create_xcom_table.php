<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%xcom}}`.
 */
class m191219_025256_create_xcom_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('{{%xcom}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('{{%xcom}}');
    }
}
