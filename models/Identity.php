<?php

namespace uzdevid\dashboard\access\control\models;

use common\models\Action;
use uzdevid\abac\IdentityPermissionInterface;

class Identity extends \uzdevid\dashboard\models\Identity implements IdentityPermissionInterface {
    public function userPermissions(): array {
        $role = Role::findOne($this->role_id);

        if (is_null($role) || empty($role->permissions)) {
            return [];
        }

        $rolePermissions = $role->permissions;

        if (in_array('*', $rolePermissions)) {
            return ['*'];
        }

        return array_map(function (array $action) {
            return $action['action'];
        }, Action::find()->select('action')->where(['in', 'id', $rolePermissions])->asArray()->all());
    }
}