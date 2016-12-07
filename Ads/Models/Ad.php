<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 24/02/16
 * Time: 16:31
 */

namespace Modules\Ads\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Mindy\Validation\UrlValidator;

class Ad extends Model
{
    public function __toString()
    {
        return (string)$this->name;
    }

    public static function getFields()
    {
        $imageSizes = Mindy::app()->getModule('Ads')->imageSizes;
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'block' => [
                'class' => ForeignField::class,
                'modelClass' => Block::class,
                'verboseName' => self::t('Block')
            ],
            'image' => [
                'force' => true,
                'class' => ImageField::class,
                'verboseName' => self::t('Image'),
                // Avoid ublock, adblock, etc...
                'uploadTo' => 'MediaBlock/MediaBlock/%Y-%m-%d/',
                'sizes' => $imageSizes
            ],
            'url' => [
                'class' => CharField::class,
                'verboseName' => self::t('Url'),
                'validators' => [
                    new UrlValidator()
                ]
            ]
        ];
    }
}