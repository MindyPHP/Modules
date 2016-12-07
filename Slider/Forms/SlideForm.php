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
 * @date 01/09/14.09.2014 13:20
 */

namespace Modules\Slider\Forms;

use Mindy\Form\ModelForm;
use Modules\Slider\Models\Slide;

class SlideForm extends ModelForm
{
    public $exclude = ['position'];

    public function getModel()
    {
        return new Slide;
    }
}
