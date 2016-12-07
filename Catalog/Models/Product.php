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
 * @date 28/07/14.07.2014 13:09
 */

namespace Modules\Catalog\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Catalog\Forms\OrderForm;

class Product extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'slug' => [
                'class' => SlugField::class,
                'verboseName' => self::t('Slug')
            ],
            'price' => [
                'class' => DecimalField::class,
                'precision' => 10,
                'scale' => 2,
                'verboseName' => self::t('Price')
            ],
            'hits' => [
                'class' => IntField::class,
                'editable' => false,
                'default' => 0,
                'verboseName' => self::t('Hits')
            ],
            'description' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Description')
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'verboseName' => self::t('Default category')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'verboseName' => self::t('Created time'),
                'editable' => false,
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'verboseName' => self::t('Updated time'),
                'editable' => false,
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'default' => false,
                'verboseName' => self::t('Is published')
            ],
            'images' => [
                'class' => HasManyField::class,
                'modelClass' => Image::class,
                'verboseName' => self::t('Name'),
                'to' => 'product_id',
                'editable' => false,
            ],
            'categories' => [
                'class' => ManyToManyField::class,
                'modelClass' => Category::class,
                'verboseName' => self::t('Categories')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('catalog:product_detail', [$this->id, $this->slug]);
    }

    public function order(OrderForm $form)
    {
        if ($data = $form->send()) {
            $app = Mindy::app();
            list($subject, $message) = $data;
            $order = new Order([
                'price' => $this->price,
                'user' => $app->user,
                'name' => $subject,
                'order' => $message
            ]);
            return $order->save();
        } else {
            return false;
        }
    }

    public function getImage()
    {
        $main = $this->images->get(['is_main' => true]);
        if ($main) {
            return $main;
        } else {
            return $this->images->limit(1)->offset(0)->get();
        }
    }

    public function getSecondImage()
    {
        return $this->images->limit(1)->offset(0)->order(['-pk'])->exclude(['is_main' => true])->get();
    }

    public function next()
    {
        return $this->objects()->filter([
            'pk__gt' => $this->pk,
            'default_category' => $this->default_category
        ])->order(['pk'])->limit(1)->offset(0)->get();
    }

    public function prev()
    {
        return $this->objects()->filter([
            'pk__lt' => $this->pk,
            'default_category' => $this->default_category
        ])->order(['-pk'])->limit(1)->offset(0)->get();
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new ProductManager($instance ? $instance : new $className);
    }
}
