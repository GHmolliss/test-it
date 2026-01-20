<?php

declare(strict_types=1);

class m000001_000007_create_subscription_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('subscription', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'author_id' => 'INT(11) UNSIGNED NOT NULL',
            'phone' => 'VARCHAR(20) NOT NULL',
            'created_at' => 'DATETIME NOT NULL',
        ]);

        $this->createIndex('idx_subscription_author_phone', 'subscription', ['author_id', 'phone'], true);

        $this->addForeignKey(
            'fk_subscription_author',
            'subscription',
            'author_id',
            'author',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down(): void
    {
        $this->dropTable('subscription');
    }
}
