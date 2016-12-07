<?php

namespace Modules\Menu\Models;

use Modules\Core\Fields\Orm\PositionField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\TreeModel;
use Modules\Menu\MenuModule;

/**
 * Class Menu
 * @method static \Mindy\Orm\TreeManager objects($instance = null)
 * @package Mindy\Orm
 */
class Menu extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'slug' => [
                'class' => CharField::class,
                'verboseName' => self::t('Slug'),
                'null' => true
            ],
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'url' => [
                'class' => CharField::class,
                'verboseName' => self::t('Url'),
                'null' => true,
                'default' => '#'
            ]
        ]);
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = self::t('Menu');
        return $names;
    }
}
