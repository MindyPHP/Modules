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

namespace Modules\Portfolio\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Portfolio\PortfolioModule;

class Image extends Model
{
    public static function getFields()
    {
        $sizes = Mindy::app()->getModule('Portfolio')->imageSizes;
        return [
            'image' => [
                'class' => ImageField::className(),
                'sizes' => $sizes,
                'null' => false,
                'verboseName' => PortfolioModule::t('Image')
            ],
            'portfolio' => [
                'class' => ForeignField::className(),
                'modelClass' => Portfolio::className(),
                'verboseName' => PortfolioModule::t('Portfolio')
            ],
            'is_main' => [
                'class' => BooleanField::className(),
                'verboseName' => PortfolioModule::t('Main image'),
            ],
            'position' => [
                'class' => IntField::class,
                'default' => 0,
                'null' => false,
                'verboseName' => self::t('Position')
            ]
        ];
    }

    /**
     * @param $owner Model
     * @param $isNew
     */
    public function beforeSave($owner, $isNew)
    {
        if ($this->is_main) {
            $qs = $this->objects()->filter(['portfolio' => $this->portfolio]);
            if ($isNew == false) {
                $qs->exclude(['pk' => $this->pk]);
            }
            $qs->update(['is_main' => false]);
        }
    }
}
