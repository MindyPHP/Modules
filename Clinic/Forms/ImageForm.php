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
use Modules\Clinic\ClinicModule;
use Modules\Clinic\Models\Image;

class ImageForm extends ModelForm
{
    public $exclude = ['department'];

    public function getModel()
    {
        return new Image;
    }

    public function getName()
    {
        return ClinicModule::t("Images");
    }
}
