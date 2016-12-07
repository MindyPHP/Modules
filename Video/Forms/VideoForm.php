<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 19/05/16 14:27
 */

namespace Modules\Video\Forms;

use Mindy\Form\Fields\CodeMirrorField;
use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Video\Models\Video;
use Modules\Video\VideoModule;

class VideoForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            VideoModule::t('Main information') => ['name', 'description', 'url', 'category'],
            VideoModule::t('HTML markup') => ['html'],
        ];
    }

    public function getFields()
    {
        return [
            'description' => [
                'class' => UEditorField::class,
            ],
            'html' => [
                'class' => CodeMirrorField::class,
                'options' => [
                    'lineNumbers' => true,
                    'mode' => 'htmlmixed',
                    'styleActiveLine' => true,
                    'matchBrackets' => true,
                    'theme' => 'material'
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new Video;
    }
}