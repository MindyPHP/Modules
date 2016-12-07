<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 02/10/14
 * Time: 14:40
 */

namespace Modules\Photo\Forms;

use Mindy\Form\ModelForm;
use Modules\Files\Fields\FilesField;
use Modules\Photo\Models\Album;
use Modules\Photo\PhotoModule;

class AlbumForm extends ModelForm
{
    public $exclude = ['position'];

    public function getModel()
    {
        return new Album;
    }

    public function getFields()
    {
        return [
            'images' => [
                'class' => FilesField::className(),
                'label' => PhotoModule::t('Images')
            ]
        ];
    }
} 