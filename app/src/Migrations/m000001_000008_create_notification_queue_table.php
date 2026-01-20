<?php

declare(strict_types=1);

class m000001_000008_create_notification_queue_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('notification_queue', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'phone' => 'VARCHAR(20) NOT NULL',
            'message' => 'TEXT NOT NULL',
            'status' => "ENUM('pending', 'sent', 'failed') NOT NULL DEFAULT 'pending'",
            'attempts' => 'TINYINT(3) UNSIGNED NOT NULL DEFAULT 0',
            'created_at' => 'DATETIME NOT NULL',
            'sent_at' => 'DATETIME',
        ]);

        $this->createIndex('idx_notification_queue_status', 'notification_queue', 'status');
    }

    public function down(): void
    {
        $this->dropTable('notification_queue');
    }
}
