<?php

namespace uzdevid\dashboard\access\control\models;

use Yii;

/**
 * @property string $translatedName
 */
class Role extends \uzdevid\dashboard\access\control\models\base\Role {
    public function getTranslatedName(): string {
        return Yii::t('system.role', $this->name);
    }
}
