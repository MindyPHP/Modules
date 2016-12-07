<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 12/09/14.09.2014 16:15
 */

namespace Modules\Antibank\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\CharField;
use Modules\Antibank\AntibankModule;
use Modules\Core\Models\SettingsModel;

class AntibankSettings extends SettingsModel
{
    public function __toString()
    {
        return (string) $this->t('Antibank settings');
    }

    public static function getFields()
    {
        return [
            'social_vk' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('VK group', [], 'settings')
            ],
            'social_fb' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Facebook group', [], 'settings')
            ],
            'skype' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Skype', [], 'settings')
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => AntibankModule::t('E-mail', [], 'settings')
            ]
        ];
    }

    public function getModule()
    {
        return Mindy::app()->getModule('Antibank');
    }

    public static function getModuleName()
    {
        return 'Antibank';
    }
}
