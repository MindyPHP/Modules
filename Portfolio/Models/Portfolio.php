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
 * @date 10/09/14.09.2014 12:27
 */

namespace Modules\Portfolio\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Portfolio\PortfolioModule;

class Portfolio extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Name')
            ],
            'description' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Content')
            ],
            'images' => [
                'class' => HasManyField::class,
                'modelClass' => Image::class,
                'to' => 'portfolio_id',
                'verboseName' => self::t('Images'),
                'editable' => false
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'null' => true,
                'verboseName' => self::t('Category')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'editable' => false,
                'verboseName' => self::t('Created at')
            ],
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('portfolio:view', ['pk' => $this->pk]);
    }

    public function getImage()
    {
        $main = $this->images->filter(['is_main' => true])->get();
        if($main) {
            return $main;
        } else {
            return $this->images->limit(1)->offset(0)->get();
        }
    }

    public function getNext()
    {
        return $this->objects()->filter([
            'pk__gt' => $this->pk,
            'category' => $this->category
        ])->order(['pk'])->limit(1)->offset(0)->get();
    }

    public function getPrev()
    {
        return $this->objects()->filter([
            'pk__lt' => $this->pk,
            'category' => $this->category
        ])->order(['-pk'])->limit(1)->offset(0)->get();
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = $this->getModule()->t('Portfolio');
        return $names;
    }

    public function afterDelete($owner)
    {
        Image::objects()->filter(['portfolio' => $owner])->delete();
    }
}
