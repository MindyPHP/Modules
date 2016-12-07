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
 * @date 14/09/14.09.2014 14:00
 */

namespace Modules\Faq\Forms;

use Mindy\Form\ModelForm;
use Modules\Faq\Models\Question;
use Modules\Meta\Forms\MetaInlineForm;

class QuestionAdminForm extends ModelForm
{
    public function getModel()
    {
        return new Question;
    }

    public function getInlines()
    {
        return [
            ['question' => AnswerForm::className()],
            ['meta' => MetaInlineForm::className()]
        ];
    }
}
