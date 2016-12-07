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
 * @date 12/09/14.09.2014 19:28
 */

namespace Modules\Faq\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Faq\FaqModule;

class Question extends Model
{
    public static function getFields()
    {
        return [
            'question' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => FaqModule::t('Question')
            ],
            'slug' => [
                'class' => SlugField::className(),
                'source' => 'question',
                'verboseName' => FaqModule::t('Slug')
            ],
            'category' => [
                'class' => ForeignField::className(),
                'modelClass' => Category::className(),
                'verboseName' => FaqModule::t('Category')
            ],
            'answers' => [
                'class' => HasManyField::className(),
                'modelClass' => Answer::className(),
                'verboseName' => FaqModule::t('Answers'),
                'editable' => false
            ],
            'is_active' => [
                'class' => BooleanField::className(),
                'verboseName' => FaqModule::t('Is active')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->question;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('faq:view', ['pk' => $this->pk]);
    }
}
