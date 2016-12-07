<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 11:28
 */

namespace Modules\UserActions\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Admin\Admin;
use Modules\Admin\AdminModule;
use Modules\UserActions\Models\UserLog;

class UserLogAdmin extends Admin
{
    public $permissions = [
        'create' => false,
        'remove' => false,
        'update' => false,
    ];

    public function getQuerySet(Model $model)
    {
        return parent::getQuerySet($model)->order(['-created_at']);
    }

    public $columns = [
        'user', 'ip', 'message', 'module', 'url', 'created_at'
    ];

    public function getActionsList()
    {
        return [];
    }

    public function getActions()
    {
        return [
            'exportCsv' => AdminModule::t('Export to csv file')
        ];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return UserLog::class;
    }
}