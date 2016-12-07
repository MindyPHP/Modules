<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/09/14.09.2014 13:16
 */

namespace Modules\Slider\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Slider\Forms\SlideForm;
use Modules\Slider\Models\Slide;

class SlideAdmin extends ModelAdmin
{
    public $sortingColumn = 'position';

    public function getColumns()
    {
        return ['name', 'url', 'is_published'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Slide;
    }

    public function getCreateForm()
    {
        return SlideForm::className();
    }
}
