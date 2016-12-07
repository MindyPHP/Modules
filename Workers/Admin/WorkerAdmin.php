<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 13/11/14 10:38
 */
namespace Modules\Workers\Admin;

use Mindy\Base\Mindy;
use Mindy\Orm\Model;
use Modules\Admin\Components\ModelAdmin;
use Modules\Workers\Forms\WorkerForm;
use Modules\Workers\Models\Worker;
use Modules\Workers\WorkersModule;

class WorkerAdmin extends ModelAdmin
{
    public $sortingColumn = 'position';

    public function getColumns()
    {
        return ['last_name', 'name', 'image'];
    }
    public function getSearchFields(){
        return ['last_name'];
    }

    public function getModel()
    {
        return new Worker;
    }

    public function getCreateForm()
    {
        return new WorkerForm();
    }

    public function getQuerySet(Model $model)
    {
        $qs = parent::getQuerySet($model);
        $user = Mindy::app()->user;
        if (!$user->is_superuser) {
            $qs->filter(['user_id' => $user->id]);
        }
        return $qs;
    }

    public function getNames($model = null)
    {
        return [
            WorkersModule::t('Workers'),
            WorkersModule::t('Create worker'),
            WorkersModule::t('Update worker'),
        ];
    }
} 
