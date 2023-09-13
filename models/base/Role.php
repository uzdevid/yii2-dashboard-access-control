<?php

namespace uzdevid\dashboard\access\control\models\base;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name
 * @property string|null $permissions
 * @property int $last_update_time
 * @property int $create_time
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'last_update_time', 'create_time'], 'required'],
            [['permissions'], 'safe'],
            [['last_update_time', 'create_time'], 'default', 'value' => null],
            [['last_update_time', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system.model', 'ID'),
            'name' => Yii::t('system.model', 'Name'),
            'permissions' => Yii::t('system.model', 'Permissions'),
            'last_update_time' => Yii::t('system.model', 'Last Update Time'),
            'create_time' => Yii::t('system.model', 'Create Time'),
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }
}
