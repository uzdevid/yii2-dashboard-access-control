<?php

namespace uzdevid\dashboard\access\control\models\service;

use uzdevid\dashboard\access\control\models\Action;
use uzdevid\dashboard\access\control\models\ActionUser;

class ActionService {
    /**
     * @return array
     */
    public static function getActions(): array {
        return Action::find()->orderBy(['path' => SORT_ASC])->all();
    }

    /**
     * @param $userId
     * @param $actionId
     * @return bool
     */
    public static function canUserDoAction($userId, $actionId): bool {
        return ActionUser::find()->where(['user_id' => $userId, 'action_id' => $actionId])->exists();
    }
}