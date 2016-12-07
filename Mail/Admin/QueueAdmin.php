<?php

/**
 * User: max
 * Date: 27/08/15
 * Time: 17:49
 */

namespace Modules\Mail\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Mail\Forms\QueueForm;
use Modules\Mail\MailModule;
use Modules\Mail\Models\Queue;

class QueueAdmin extends Admin
{
    public $columns = ['name', 'subject', 'count', 'is_complete', 'started_at', 'stopped_at'];

    public function verboseNames()
    {
        return [
            'count' => MailModule::t('Count')
        ];
    }

    public function getCreateForm()
    {
        return QueueForm::className();
    }

    public function getModelClass()
    {
        return Queue::class;
    }
}
