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
 * @date 19/02/15 07:04
 */
namespace Modules\Vacants\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Vacants\Models\File;
use Modules\Vacants\VacantsModule;

class FileAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new File;
    }
    
    public function getNames($model = null)
    {
        return [
            VacantsModule::t('Files'),
            VacantsModule::t('Create File'),
            VacantsModule::t('Update File')
        ];
    }
}