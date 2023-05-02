<?php

namespace uzdevid\dashboard\access\control\filters;

use uzdevid\dashboard\access\control\models\Action;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class DashboardAccessControl extends Behavior {
    public function events() {
        return [
            Controller::EVENT_BEFORE_ACTION => 'checkAccess',
        ];
    }

    public function checkAccess($event) {
        if (class_exists(Action::class)) {
            $access = Action::find()->where(['path' => $this->owner->action->uniqueId])->one();

            if (is_null($access)) {
                throw new BadRequestHttpException(Yii::t('system.message', 'Action not found in permissions'));
            }

            $actionUsers = ArrayHelper::map($access->users, 'user_id', 'user_id');

            if (!in_array(Yii::$app->user->id, $actionUsers)) {
                throw new ForbiddenHttpException(Yii::t('system.message', 'You are not allowed to perform this action.'));
            }
        }
    }
}