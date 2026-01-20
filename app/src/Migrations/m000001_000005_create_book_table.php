<?php

declare(strict_types=1);

class m000001_000005_create_book_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('book', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'VARCHAR(255) NOT NULL',
            'year' => 'SMALLINT(4) UNSIGNED NOT NULL',
            'description' => 'TEXT',
            'isbn' => 'VARCHAR(20)',
            'cover_image' => 'VARCHAR(255)',
            'created_at' => 'DATETIME NOT NULL',
            'updated_at' => 'DATETIME NOT NULL',
        ]);

        $this->createIndex('idx_book_title', 'book', 'title');
        $this->createIndex('idx_book_year', 'book', 'year');
        $this->createIndex('idx_book_isbn', 'book', 'isbn');
    }

    public function down(): void
    {
        $this->dropTable('book');
    }
}
