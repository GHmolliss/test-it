<?php

declare(strict_types=1);

class m000001_000006_create_book_author_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('book_author', [
            'book_id' => 'INT(11) UNSIGNED NOT NULL',
            'author_id' => 'INT(11) UNSIGNED NOT NULL',
            'PRIMARY KEY (book_id, author_id)',
        ]);

        $this->addForeignKey(
            'fk_book_author_book',
            'book_author',
            'book_id',
            'book',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_book_author_author',
            'book_author',
            'author_id',
            'author',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down(): void
    {
        $this->dropTable('book_author');
    }
}
