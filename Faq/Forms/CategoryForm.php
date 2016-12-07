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
 * @date 14/09/14.09.2014 14:01
 */

namespace Modules\Faq\Forms;

use Mindy\Form\ModelForm;
use Modules\Faq\Models\Category;

class CategoryForm extends ModelForm
{
    public $exclude = ['questions'];

    public function getModel()
    {
        return new Category;
    }
}
