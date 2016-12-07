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
 * @date 28/07/14.07.2014 14:50
 */

namespace Modules\Catalog\Forms;

use Mindy\Form\ModelForm;
use Modules\Catalog\Models\Image;

class ImageInlineForm extends ModelForm
{
    public $exclude = ['product'];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Image;
    }
}

