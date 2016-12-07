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
 * @date 17/11/14.11.2014 16:24
 */

namespace Modules\Mail\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Admin\Admin;
use Modules\Mail\Forms\MailForm;
use Modules\Mail\Models\Mail;

class MailAdmin extends Admin
{
    public $permissions = [
        'create' => false
    ];

    public $columns = [
        'email',
        'subject',
        'created_at',
        'readed_at',
        'queue'
    ];

    public $searchFields = ['subject', 'email', 'queue__name'];

    /**
     * @param Model $model
     * @return \Mindy\Orm\QuerySet
     */
    public function getQuerySet(Model $model)
    {
        return parent::getQuerySet($model)->order(['-id']);
    }

    public function getCreateForm()
    {
        return MailForm::class;
    }

    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Mail::class;
    }
}
