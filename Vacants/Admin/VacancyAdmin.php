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
 * @date 19/02/15 06:56
 */
namespace Modules\Vacants\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Vacants\Models\Vacancy;
use Modules\Vacants\VacantsModule;

class VacancyAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new Vacancy;
    }
    
    public function getNames($model = null)
    {
        return [
            VacantsModule::t('Vacancies'),
            VacantsModule::t('Create Vacancy'),
            VacantsModule::t('Update Vacancy')
        ];
    }
}