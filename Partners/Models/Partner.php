<?php

namespace Modules\Partners\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Model;
use Modules\Partners\PartnersModule;

/**
 * Class Module
 * @package Modules\Partners
 * @method static \Modules\Partners\Models\PartnerManager objects($instance = null)
 */
class Partner extends Model
{
    public static function getFields()
    {
        $sizes = Mindy::app()->getModule('Partners')->logoSizes;

        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => PartnersModule::t('Name'),
                'required' => true,
            ],
            'address' => [
                'class' => CharField::className(),
                'verboseName' => PartnersModule::t('Address'),
                'null' => true
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => PartnersModule::t('Email'),
                'null' => true
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => PartnersModule::t('Phone'),
                'null' => true
            ],
            'url' => [
                'class' => CharField::className(),
                'verboseName' => PartnersModule::t('Url'),
                'null' => true
            ],
            'is_published' => [
                'class' => BooleanField::className(),
                'verboseName' => PartnersModule::t('Is published'),
                'default' => false
            ],
            'logo' => [
                'class' => ImageField::className(),
                'verboseName' => PartnersModule::t('Logo'),
                'null' => true,
                'storeOriginal' => true,
                'sizes' => $sizes
            ]
        ];
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new PartnerManager($instance ? $instance : new $className);
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
