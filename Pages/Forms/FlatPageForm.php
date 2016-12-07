<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 02/03/16
 * Time: 14:21
 */

namespace Modules\Pages\Forms;

use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Pages\PagesModule;

class FlatPageForm extends ModelForm
{
    public function getFields()
    {
        return [
            'content_short' => [
                'class' => TextAreaField::class,
                'label' => PagesModule::t('Short content')
            ],
            'content' => [
                'class' => UEditorField::class,
                'label' => PagesModule::t('Content')
            ],
        ];
    }
}