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
 * @date 30/10/14.10.2014 17:34
 */

namespace Modules\Wiki\Forms;

use Mindy\Form\ModelForm;
use Modules\Wiki\Models\Wiki;

class WikiForm extends ModelForm
{
    public function getModel()
    {
        return new Wiki;
    }
}
