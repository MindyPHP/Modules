<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:14
 */

namespace Modules\Clinic\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Clinic\Forms\WorkerForm;
use Modules\Clinic\Models\Worker;

class WorkerAdmin extends ModelAdmin
{
    /**
     * @return string
     */
    public function getCreateForm()
    {
        return WorkerForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Worker;
    }
}
