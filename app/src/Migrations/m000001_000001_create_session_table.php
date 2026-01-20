<?php

declare(strict_types=1);

class m000001_000001_create_session_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('session', [
            'id' => 'CHAR(32) NOT NULL PRIMARY KEY',
            'expire' => 'INT(11)',
            'data' => 'LONGBLOB',
        ]);
    }

    public function down(): void
    {
        $this->dropTable('session');
    }
}
