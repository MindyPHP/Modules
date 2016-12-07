<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 17:41
 */

namespace Modules\Places\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Places\PlacesModule;

class Image extends Model
{
    public static function getFields()
    {
        return [
            'image' => [
                'class' => ImageField::className(),
                'sizes' => [
                    'thumb' => [84, 56],
                    'small' => [130, 130],
                    'retina' => [176, 116],
                    'new' => [1000, 625],
                ],
                'null' => false,
                'verboseName' => PlacesModule::t('Image')
            ],
            'place' => [
                'class' => ForeignField::className(),
                'modelClass' => Place::className(),
                'verboseName' => PlacesModule::t('Place')
            ],
            'is_main' => [
                'class' => BooleanField::className(),
                'verboseName' => PlacesModule::t('Main image'),
            ],
        ];
    }

    /**
     * @param $owner Model
     * @param $isNew
     */
    public function beforeSave($owner, $isNew)
    {
        if ($this->is_main) {
            $qs = $this->objects()->filter(['place' => $this->place]);
            if ($isNew == false) {
                $qs->exclude(['pk' => $this->pk]);
            }
            $qs->update(['is_main' => false]);
        }
    }
}
