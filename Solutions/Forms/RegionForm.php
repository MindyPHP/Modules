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
 * @date 15/09/14.09.2014 16:15
 */

namespace Modules\Solutions\Forms;

use Mindy\Form\ModelForm;
use Modules\Solutions\Models\Region;

class RegionForm extends ModelForm
{
    public $exclude = ['region_set'];

    public function getModel()
    {
        return new Region;
    }
}
