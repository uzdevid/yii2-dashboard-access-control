<?php

use yii\db\Migration;

/**
 * Class m230502_100611_role
 */
class m230502_100611_role extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('role', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),

            'permissions' => $this->json()->null()->defaultValue(null),
            'last_update_time' => $this->bigInteger()->notNull(),
            'create_time' => $this->bigInteger()->notNull()
        ]);

        $this->insert('role', [
            'name' => 'admin',
            'permissions' => ['*'],
            'last_update_time' => time(),
            'create_time' => time()
        ]);

        $this->insert('role', [
            'name' => 'manager',
            'permissions' => ['*'],
            'last_update_time' => time(),
            'create_time' => time()
        ]);

        $this->addColumn('user', 'role_id', $this->integer()->notNull()->after('user_id')->defaultValue(2));
        $this->addForeignKey('fk_user_role_id', 'user', 'role_id', 'role', 'id', 'SET NULL', 'CASCADE');

        $this->update('user', ['role_id' => 1], ['id' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('role');
        return true;
    }
}
