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
            'path' => $this->string(255)->notNull()
        ]);

        $this->batchInsert('action', ['id', 'path'], [
            ['id' => 1, 'path' => 'system/default/index'],
            //
            ['id' => 2, 'path' => 'system/user/create'],
            ['id' => 3, 'path' => 'system/user/delete'],
            ['id' => 4, 'path' => 'system/user/index'],
            ['id' => 5, 'path' => 'system/user/online-users'],
            ['id' => 6, 'path' => 'system/user/permissions'],
            ['id' => 7, 'path' => 'system/user/view'],
            //
            ['id' => 8, 'path' => 'system/action/index'],
            ['id' => 9, 'path' => 'system/action/create'],
            ['id' => 10, 'path' => 'system/action/update'],
            ['id' => 11, 'path' => 'system/action/view'],
            //
            ['id' => 12, 'path' => 'system/role/create'],
            ['id' => 13, 'path' => 'system/role/index'],
            //
            ['id' => 14, 'path' => 'system/api/menu/index'],
            ['id' => 15, 'path' => 'system/api/menu/sort-completed'],
            ['id' => 16, 'path' => 'system/api/user/permission'],
            //
            ['id' => 17, 'path' => 'system/menu/create'],
            ['id' => 18, 'path' => 'system/menu/delete'],
            ['id' => 19, 'path' => 'system/menu/index'],
            ['id' => 20, 'path' => 'system/menu/update'],
            ['id' => 21, 'path' => 'system/menu/view'],
            //
            ['id' => 22, 'path' => 'system/yii-message/create'],
            ['id' => 23, 'path' => 'system/yii-message/delete'],
            ['id' => 24, 'path' => 'system/yii-message/index'],
            ['id' => 25, 'path' => 'system/yii-message/update'],
            ['id' => 26, 'path' => 'system/yii-message/view'],
            //
            ['id' => 27, 'path' => 'system/yii-source-message/create'],
            ['id' => 28, 'path' => 'system/yii-source-message/delete'],
            ['id' => 29, 'path' => 'system/yii-source-message/index'],
            ['id' => 30, 'path' => 'system/yii-source-message/update'],
            ['id' => 31, 'path' => 'system/yii-source-message/view'],
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
