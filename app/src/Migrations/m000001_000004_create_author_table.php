<?php

declare(strict_types=1);

class m000001_000004_create_author_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('author', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'full_name' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'DATETIME NOT NULL',
            'updated_at' => 'DATETIME NOT NULL',
        ]);

        $this->createIndex('idx_author_full_name', 'author', 'full_name');
    }

    public function down(): void
    {
        $this->dropTable('author');
    }
}
