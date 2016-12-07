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

namespace Modules\Portfolio\Forms;

use Mindy\Form\Fields\ImageField;
use Mindy\Form\ModelForm;
use Mindy\Validation\ImageValidator;
use Modules\Portfolio\Models\Image;
use Modules\Portfolio\PortfolioModule;

class ImageForm extends ModelForm
{
    public $exclude = ['portfolio'];

    public function getFields()
    {
        return [
            'image' => [
                'class' => ImageField::className(),
                'validators' => [
                    new ImageValidator(1920, 1080)
                ],
            ],
        ];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Image;
    }

    public function getName()
    {
        return PortfolioModule::t("Images");
    }
}
