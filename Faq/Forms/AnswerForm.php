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
 * @date 14/09/14.09.2014 14:02
 */

namespace Modules\Faq\Forms;

use Mindy\Form\ModelForm;
use Modules\Faq\FaqModule;
use Modules\Faq\Models\Answer;

class AnswerForm extends ModelForm
{
    public $exclude = ['question'];

    public function getModel()
    {
        return new Answer;
    }

    public function getName()
    {
        return FaqModule::t('Answers');
    }
}
