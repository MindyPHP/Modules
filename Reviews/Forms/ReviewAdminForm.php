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
 * @date 27/08/14.08.2014 14:56
 */

namespace Modules\Reviews\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;

class ReviewAdminForm extends ModelForm
{
    public $exclude = ['created_at', 'updated_at'];

    public function getModel()
    {
        $cls = Mindy::app()->getModule('Reviews')->modelClass;
        return new $cls;
    }
}
