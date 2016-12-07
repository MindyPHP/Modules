<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 17:39
 */

namespace Modules\Places\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\FloatField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Places\PlacesModule;

class Place extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => PlacesModule::t('Name')
            ],
            'address' => [
                'class' => CharField::className(),
                'verboseName' => PlacesModule::t('Address')
            ],
            'lat' => [
                'class' => FloatField::className(),
                'verboseName' => PlacesModule::t('Latitude')
            ],
            'lng' => [
                'class' => FloatField::className(),
                'verboseName' => PlacesModule::t('Longitude')
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => PlacesModule::t('Phone')
            ],
            'content_short' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => PlacesModule::t('Short content')
            ],
            'content' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => PlacesModule::t('Content')
            ],
            'images' => [
                'class' => HasManyField::className(),
                'modelClass' => Image::className(),
                'verboseName' => PlacesModule::t('Images'),
                'editable' => false
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('places.detail', ['pk' => $this->pk]);
    }

    public function getImage()
    {
        $image = $this->images->filter(['is_main' => true])->get();
        if ($image === null) {
            $image = $this->images->limit(1)->offset(0)->get();
        }

        return $image;
    }
}
