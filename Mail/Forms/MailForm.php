<?php

/**
 * User: max
 * Date: 31/08/15
 * Time: 14:18
 */

namespace Modules\Mail\Forms;

use Mindy\Form\Fields\AceField;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\CheckboxField;
use Mindy\Form\Fields\DateTimeField;
use Mindy\Form\Fields\DropDownField;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\TextField;
use Mindy\Form\ModelForm;
use Modules\Mail\Models\Mail;

class MailForm extends ModelForm
{
    public function getFields()
    {
        return [
            'queue' => [
                'class' => DropDownField::class,
                'html' => [
                    'disabled' => true
                ]
            ],
            'email' => [
                'class' => EmailField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'subject' => [
                'class' => CharField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'message_txt' => [
                'class' => TextField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'message_html' => [
                'class' => TextField::class,
                'html' => [
                    'readOnly' => true
                ]
            ],
            'error' => [
                'class' => TextField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'is_sended' => [
                'class' => CheckboxField::class,
                'html' => [
                    'disabled' => true
                ]
            ],
            'is_read' => [
                'class' => CheckboxField::class,
                'html' => [
                    'disabled' => true
                ]
            ],
            'readed_at' => [
                'class' => DateTimeField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'html' => [
                    'readonly' => true
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new Mail;
    }
}
