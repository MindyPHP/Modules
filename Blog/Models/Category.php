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
 * @date 29/09/14.09.2014 19:11
 */

namespace Modules\Blog\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;
use Modules\Blog\BlogModule;

class Category extends TreeModel
{
    public static function getFields()
    {
        return array_merge([
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => BlogModule::t('Name')
            ],
            'slug' => [
                'class' => SlugField::className(),
                'source' => 'name',
                'verboseName' => BlogModule::t('Slug'),
                'unique' => true
            ],
            'content' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => BlogModule::t('Content')
            ],
            'content_short' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => BlogModule::t('Short content')
            ],
            'posts' => [
                'class' => HasManyField::className(),
                'modelClass' => Post::className()
            ],
        ], parent::getFields());
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('blog:list', ['slug' => $this->slug]);
    }

    public function getAdminNames($instance = null)
    {
        $module = $this->getModule();
        $cls = self::classNameShort();
        $name = self::normalizeName($cls);
        if ($instance) {
            $updateTranslate = $module->t('Update ' . $name . ': {name}', ['{name}' => (string)$instance]);
        } else {
            $updateTranslate = $module->t('Update ' . $name);
        }
        return [
            $module->t('Categories'),
            $module->t('Create category'),
            $updateTranslate,
        ];
    }
}
