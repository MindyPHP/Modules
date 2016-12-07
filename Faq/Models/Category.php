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
 * @date 12/09/14.09.2014 19:26
 */

namespace Modules\Faq\Models;


use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Faq\FaqModule;

class Category extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => FaqModule::t('Name')
            ],
            'url' => [
                'class' => SlugField::className(),
                'source' => 'name',
                'verboseName' => FaqModule::t('Url')
            ],
            'description' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => FaqModule::t('Content')
            ],
            'questions' => [
                'class' => HasManyField::className(),
                'modelClass' => Question::className(),
                'verboseName' => FaqModule::t('Questions')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('faq:list', ['url' => $this->url]);
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = $this->getModule()->t('Categories');
        return $names;
    }
}
