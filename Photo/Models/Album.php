<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 02/10/14
 * Time: 14:34
 */

namespace Modules\Photo\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\User\Models\User;

class Album extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name'),
                'required' => true,
            ],
            'description' => [
                'class' => TextField::class,
                'verboseName' => self::t('Description')
            ],
            'author' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'verboseName' => self::t('Author'),
                'null' => true
            ],
            'position' => [
                'class' => IntField::class,
                'verboseName' => self::t('Position'),
                'default' => 0,
            ],
            'images' => [
                'class' => HasManyField::class,
                'verboseName' => self::t('Images'),
                'modelClass' => Image::class
            ]
        ];
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('photo:view', ['pk' => $this->pk]);
    }

    public function getCover()
    {
        return $this->images->limit(1)->offset(0)->get();
    }
} 