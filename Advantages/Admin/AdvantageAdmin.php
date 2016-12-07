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
 * @date 07/11/14 15:33
 */
namespace Modules\Advantages\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Advantages\AdvantagesModule;
use Modules\Advantages\Forms\AdvantageForm;
use Modules\Advantages\Models\Advantage;

class AdvantageAdmin extends ModelAdmin
{
    public $sortingColumn = 'position';

    public function orderColumns()
    {
        return ['position'];
    }

    public function getColumns()
    {
        return ['name'];
    }

    public function getModel()
    {
        return new Advantage;
    }

    public function getCreateForm()
    {
        return new AdvantageForm();
    }

    public function getNames($model = null)
    {
        return [
            AdvantagesModule::t('Advantages'),
            AdvantagesModule::t('Create advantage'),
            AdvantagesModule::t('Update advantage')
        ];
    }
} 