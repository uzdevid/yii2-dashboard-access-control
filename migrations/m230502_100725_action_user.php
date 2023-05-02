<?php

use yii\db\Migration;

/**
 * Class m230502_100725_action_user
 */
class m230502_100725_action_user extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('action_user', [
            'id' => $this->primaryKey(),
            'action_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_action_user_action', 'action_user', 'action_id', 'action', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_action_user_user', 'action_user', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];

        foreach ($permissions as $permission) {
            $this->insert('action_user', ['action_id' => $permission, 'user_id' => 1]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('action_user');
        return true;
    }
}
