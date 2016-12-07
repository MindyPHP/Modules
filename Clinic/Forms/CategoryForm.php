<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/11/14 18:05
 */

namespace Modules\Clinic\Forms;

use Mindy\Form\ModelForm;
use Modules\Clinic\Models\Category;

class CategoryForm extends ModelForm
{
    public function getModel()
    {
        return new Category;
    }
}
