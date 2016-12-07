<?php

/**
 * User: max
 * Date: 31/08/15
 * Time: 16:40
 */

namespace Modules\Mail\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Mail\MailModule;
use Modules\Mail\Models\UrlChecker;

class UrlCheckerAdmin extends Admin
{
    public $columns = ['mail', 'url'];

    public $permissions = [
        'create' => false
    ];

    public function getActions()
    {
        return [];
    }

    /**
     * Verbose names for custom columns
     * @return array
     */
    public function getVerboseNames()
    {
        return [
            'mail__email' => MailModule::t('Mail')
        ];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return UrlChecker::class;
    }
}
