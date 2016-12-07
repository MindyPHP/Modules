<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 24/02/16
 * Time: 16:34
 */

namespace Modules\Ads\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Model;

class Block extends Model
{
    public function __toString()
    {
        return (string)$this->name;
    }

    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'slug' => [
                'class' => SlugField::class,
                'verboseName' => self::t('Slug'),
                'unique' => true
            ]
        ];
    }
}