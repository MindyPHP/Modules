<?php

namespace Modules\Furniture\Models;

use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Model;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DecimalField;

class Furniture extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
            ],
            'slug' => [
                'class' => SlugField::className(),
                'unique' => true
            ],
            'price' => [
                'class' => DecimalField::className(),
                'precision' => 10,
                'scale' => 2
            ]
        ];
    }
    
    public function __toString()
    {
        return $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('furniture:view', ['slug' => $this->slug]);
    }
}