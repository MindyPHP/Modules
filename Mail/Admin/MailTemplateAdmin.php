<?php

namespace Modules\Mail\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Mail\Forms\MailTemplateForm;
use Modules\Mail\Models\MailTemplate;

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 16/05/14.05.2014 15:12
 */
class MailTemplateAdmin extends Admin
{
    public $columns = ['code', 'subject'];

    /**
     * @return string
     */
    public function getCreateForm()
    {
        return MailTemplateForm::class;
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return MailTemplate::class;
    }
}
