<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 02/12/14 17:36
 */

namespace Modules\Partners\Forms;

use Mindy\Form\ModelForm;
use Modules\Partners\Models\Partner;

class PartnerForm extends ModelForm
{
    public function getModel()
    {
        return new Partner;
    }
}
