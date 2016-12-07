<?php

namespace Modules\Nav\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ImageField;
use Modules\Menu\Models\Menu;
use Modules\Nav\NavModule;

/**
 * Class Menu
 * @method static \Mindy\Orm\TreeManager tree($instance = null)
 * @method static \Mindy\Orm\Manager objects($instance = null)
 * @package Mindy\Orm
 */
class Nav extends Menu
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => NavModule::t('Image')
            ],
            'video' => [
                'class' => CharField::className(),
                'verboseName' => NavModule::t('Video'),
                'null' => true
            ],
            'label' => [
                'class' => CharField::className(),
                'verboseName' => NavModule::t('Label'),
                'null' => true
            ],
            'label_color' => [
                'class' => CharField::className(),
                'verboseName' => NavModule::t('Label color'),
                'null' => true
            ],
            'label_bg' => [
                'class' => CharField::className(),
                'verboseName' => NavModule::t('Label background'),
                'null' => true
            ]
        ]);
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
