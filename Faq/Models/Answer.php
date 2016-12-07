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
 * @date 12/09/14.09.2014 19:33
 */

namespace Modules\Faq\Models;

use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Faq\FaqModule;

class Answer extends Model
{
    public static function getFields()
    {
        return [
            'answer' => [
                'class' => TextField::className(),
                'verboseName' => FaqModule::t('Answer')
            ],
            'question' => [
                'class' => ForeignField::className(),
                'required' => true,
                'modelClass' => Question::className(),
                'verboseName' => FaqModule::t('Question')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->answer;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('faq:view', ['pk' => $this->pk]) . '#' . $this->pk;
    }
}
