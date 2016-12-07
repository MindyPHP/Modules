<?php

namespace Modules\Offices\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;

class Category extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name'),
            ],
            'position' => [
                'class' => IntField::class,
                'editable' => false,
                'default' => 0,
                'verboseName' => self::t('Position')
            ],
            'offices' => [
                'class' => HasManyField::class,
                'modelClass' => Office::class,
                'verboseName' => self::t('Offices')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = self::t('Categories');
        return $names;
    }

    /*
    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new CategoryManager($instance ? $instance : new $className);
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('offices:category', ['pk' => $this->pk]);
    }
    */
}
