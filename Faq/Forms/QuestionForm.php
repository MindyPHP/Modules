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
 * @date 14/09/14.09.2014 14:01
 */

namespace Modules\Faq\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;
use Modules\Faq\Models\Question;

class QuestionForm extends ModelForm
{
    public $exclude = ['answers', 'slug', 'is_active'];

    public function getModel()
    {
        return new Question;
    }

    public function save()
    {
        $status = parent::save();
        if ($status) {
            Mindy::app()->mail->fromCode('faq.new_question', Mindy::app()->managers, [
                'model' => $this->getInstance()
            ]);
        }
        return $status;
    }
}
