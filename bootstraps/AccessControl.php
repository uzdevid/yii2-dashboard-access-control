<?php

namespace uzdevid\dashboard\access\control\bootstraps;

use uzdevid\dashboard\access\control\controllers\ActionController;
use uzdevid\dashboard\access\control\controllers\RoleController;
use uzdevid\dashboard\events\ModuleEvent;
use uzdevid\dashboard\modules\system\Module;
use yii\base\BootstrapInterface;

class AccessControl implements BootstrapInterface {
    public function bootstrap($app) {
        $app->on(Module::EVENT_AFTER_INIT, function (ModuleEvent $event) {
            $event->module->controllerMap['role'] = RoleController::class;
            $event->module->controllerMap['action'] = ActionController::class;
        });
    }
}