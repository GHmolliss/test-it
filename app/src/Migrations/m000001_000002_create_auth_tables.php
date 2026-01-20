<?php

declare(strict_types=1);

class m000001_000002_create_auth_tables extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('auth_item', [
            'name' => 'VARCHAR(64) NOT NULL PRIMARY KEY',
            'type' => 'INT(11) NOT NULL',
            'description' => 'TEXT',
            'bizrule' => 'TEXT',
            'data' => 'TEXT',
        ]);

        $this->createTable('auth_item_child', [
            'parent' => 'VARCHAR(64) NOT NULL',
            'child' => 'VARCHAR(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
        ]);

        $this->addForeignKey(
            'fk_auth_item_child_parent',
            'auth_item_child',
            'parent',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_auth_item_child_child',
            'auth_item_child',
            'child',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('auth_assignment', [
            'itemname' => 'VARCHAR(64) NOT NULL',
            'userid' => 'VARCHAR(64) NOT NULL',
            'bizrule' => 'TEXT',
            'data' => 'TEXT',
            'PRIMARY KEY (itemname, userid)',
        ]);

        $this->addForeignKey(
            'fk_auth_assignment_item',
            'auth_assignment',
            'itemname',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->insert('auth_item', ['name' => 'user', 'type' => CAuthItem::TYPE_ROLE, 'description' => 'Зарегистрированный пользователь']);
    }

    public function down(): void
    {
        $this->dropTable('auth_assignment');
        $this->dropTable('auth_item_child');
        $this->dropTable('auth_item');
    }
}
