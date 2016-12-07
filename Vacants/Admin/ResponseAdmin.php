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
 * @date 19/02/15 06:53
 */
namespace Modules\Vacants\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Components\ModelAdmin;
use Modules\Vacants\Models\Response;
use Modules\Vacants\VacantsModule;

class ResponseAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'phone'];
    }
    
    public function getModel()
    {
        return new Response;
    }

    public function getActionsList()
    {
        return ['info', 'delete'];
    }

    public function getQuerySet(Model $model)
    {
        return $model->objects()->getQuerySet()->order(['-created_at']);
    }

    public function getNames($model = null)
    {
        return [
            VacantsModule::t('Responses'),
            VacantsModule::t('Create Response'),
            VacantsModule::t('Update Response')
        ];
    }
}