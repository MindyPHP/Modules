<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 02/10/14
 * Time: 14:34
 */

namespace Modules\Photo\Models;

use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;

class Image extends Model
{
    public static function getFields()
    {
        return [
            'album' => [
                'class' => ForeignField::class,
                'verboseName' => self::t('Album'),
                'modelClass' => Album::class,
                'required' => true
            ],
            'position' => [
                'class' => IntField::class,
                'verboseName' => self::t('Position'),
                'default' => 0
            ],
            'file' => [
                'class' => ImageField::class,
                'sizes' => [
                    [295, 216]
                ],
                'verboseName' => self::t('Image')
            ]
        ];
    }
} 