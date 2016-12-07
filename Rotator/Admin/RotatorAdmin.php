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
 * @date 06/11/14 16:57
 */
namespace Modules\Rotator\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Rotator\Models\Rotator;
use Modules\Rotator\RotatorModule;

class RotatorAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'title'];
    }

    public function getModel()
    {
        return new Rotator;
    }

    public function getNames($model = null)
    {
        return [
            RotatorModule::t('Rotator'),
            RotatorModule::t('Create slide'),
            RotatorModule::t('Update slide')
        ];
    }
} 