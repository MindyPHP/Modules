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
 * @date 14/09/14.09.2014 13:51
 */

namespace Modules\Faq\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Faq\Forms\QuestionAdminForm;
use Modules\Faq\Models\Question;

class QuestionAdmin extends ModelAdmin
{
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Question;
    }

    public function getColumns()
    {
        return ['question', 'is_active'];
    }

    public function getCreateForm()
    {
        return QuestionAdminForm::className();
    }
}
