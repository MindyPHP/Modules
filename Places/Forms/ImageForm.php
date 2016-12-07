<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 04/12/14 14:11
 */

namespace Modules\Places\Forms;

use Mindy\Form\ModelForm;
use Modules\Places\Models\Image;
use Modules\Places\PlacesModule;

class ImageForm extends ModelForm
{
    public $exclude = ['place'];

    public function getModel()
    {
        return new Image;
    }

    public function getName()
    {
        return PlacesModule::t('Images');
    }
}
