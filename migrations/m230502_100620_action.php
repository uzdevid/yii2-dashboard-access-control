<?php

use yii\db\Migration;

/**
 * Class m230502_100620_action
 */
class m230502_100620_action extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('action', [
            'id' => $this->primaryKey(),
            'action' => $this->string(255)->notNull()->unique(),
        ]);

        $this->batchInsert('action', ['id', 'action'], [
            ['id' => 10101, 'action' => 'system.user.index'],
            ['id' => 10102, 'action' => 'system.user.create'],
            ['id' => 10103, 'action' => 'system.user.update'],
            ['id' => 10104, 'action' => 'system.user.view'],
            ['id' => 10105, 'action' => 'system.user.delete'],
            ['id' => 10106, 'action' => 'system.user.online-users'],
            //
            ['id' => 10201, 'action' => 'system.action.index'],
            ['id' => 10202, 'action' => 'system.action.create'],
            ['id' => 10203, 'action' => 'system.action.update'],
            ['id' => 10204, 'action' => 'system.action.view'],
            ['id' => 10205, 'action' => 'system.action.delete'],
            //
            ['id' => 10301, 'action' => 'system.role.index'],
            ['id' => 10302, 'action' => 'system.role.create'],
            ['id' => 10303, 'action' => 'system.role.update'],
            ['id' => 10304, 'action' => 'system.role.view'],
            ['id' => 10305, 'action' => 'system.role.delete'],
            ['id' => 10306, 'action' => 'system.role.permissions'],
            //
            ['id' => 10401, 'action' => 'system.menu.index'],
            ['id' => 10402, 'action' => 'system.menu.create'],
            ['id' => 10403, 'action' => 'system.menu.update'],
            ['id' => 10404, 'action' => 'system.menu.view'],
            ['id' => 10405, 'action' => 'system.menu.delete'],
            //
            ['id' => 10501, 'action' => 'system.yii-message.index'],
            ['id' => 10502, 'action' => 'system.yii-message.create'],
            ['id' => 10503, 'action' => 'system.yii-message.update'],
            ['id' => 10504, 'action' => 'system.yii-message.view'],
            ['id' => 10505, 'action' => 'system.yii-message.delete'],
            //
            ['id' => 10601, 'action' => 'system.yii-source-message.index'],
            ['id' => 10602, 'action' => 'system.yii-source-message.create'],
            ['id' => 10603, 'action' => 'system.yii-source-message.update'],
            ['id' => 10604, 'action' => 'system.yii-source-message.view'],
            ['id' => 10605, 'action' => 'system.yii-source-message.delete'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('action');
        return true;
    }
}
