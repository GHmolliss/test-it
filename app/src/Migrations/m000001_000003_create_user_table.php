<?php

declare(strict_types=1);

class m000001_000003_create_user_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('user', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'phone' => 'VARCHAR(20) NOT NULL',
            'password_hash' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'DATETIME NOT NULL',
            'updated_at' => 'DATETIME NOT NULL',
        ]);

        $this->createIndex('idx_user_phone', 'user', 'phone', true);
    }

    public function down(): void
    {
        $this->dropTable('user');
    }
}
