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
 * @date 28/07/14.07.2014 13:07
 */

namespace Modules\Catalog\Models;

use Mindy\Orm\Fields\AutoSlugField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;

class Category extends TreeModel
{
    public static function getFields()
    {
        return array_merge([
            'name' => [
                'class' => CharField::className(),
                'length' => 255,
                'verboseName' => self::t('Name')
            ],
            'url' => [
                'class' => AutoSlugField::className(),
                'length' => 255,
                'verboseName' => self::t('Url')
            ],
            'description' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => self::t('Description')
            ],
            'production' => [
                'class' => ManyToManyField::className(),
                'modelClass' => Product::className(),
                'relatedName' => 'category',
                'verboseName' => self::t('Productions'),
                'editable' => false,
            ]
        ], parent::getFields());
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('catalog:list', [$this->url]);
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = $this->getModule()->t('Categories');
        return $names;
    }
}
