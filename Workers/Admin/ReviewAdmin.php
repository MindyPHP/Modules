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
 * @date 13/11/14 10:37
 */
namespace Modules\Workers\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Workers\Models\Review;
use Modules\Workers\WorkersModule;

class ReviewAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'worker', 'video'];
    }
    public function getSearchFields(){
        return ['video'];
    }

    public function getModel()
    {
        return new Review;
    }

    public function getNames($model = null)
    {
        return [
            WorkersModule::t('Reviews'),
            WorkersModule::t('Create review'),
            WorkersModule::t('Update review'),
        ];
    }
} 
