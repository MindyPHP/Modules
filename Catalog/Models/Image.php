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
 * @date 28/07/14.07.2014 13:13
 */

namespace Modules\Catalog\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Catalog\CatalogModule;

class Image extends Model
{
    public static function getFields()
    {
        return [
            'image' => [
                'class' => ImageField::className(),
                'sizes' => [
                    'thumb' => [150, 230],
                    'preview' => [300, 420],
                ],
                'verboseName' => CatalogModule::t('Image')
            ],
            'product' => [
                'class' => ForeignField::className(),
                'modelClass' => Product::className(),
                'relatedName' => 'images',
                'verboseName' => CatalogModule::t('Product')
            ],
            'is_main' => [
                'class' => BooleanField::className(),
                'verboseName' => CatalogModule::t('Is main'),
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
            $qs = $this->objects()->filter(['product' => $this->product]);
            if ($isNew == false) {
                $qs->exclude(['pk' => $this->pk]);
            }
            $qs->update(['is_main' => false]);
        }
    }
}
