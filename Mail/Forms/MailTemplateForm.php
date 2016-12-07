<?php

namespace Modules\Mail\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\AceField;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\CheckboxField;
use Mindy\Form\Fields\CodeMirrorField;
use Mindy\Form\Fields\TextField;
use Mindy\Form\ModelForm;
use Mindy\Form\Widget\CodeMirrorWidget;
use Modules\Mail\MailModule;
use Modules\Mail\Models\MailTemplate;

class MailTemplateForm extends ModelForm
{
    public function getFields()
    {
        $hint = '';
        if ($this->getModel()->getIsNewRecord() == false) {
            $codes = [];
            if (Mindy::app()->hasModule($this->getModel()->module)) {
                $module = Mindy::app()->getModule($this->getModel()->module);
                if (isset($module->mailTemplates[$this->getModel()->code])) {
                    $codes = $module->mailTemplates[$this->getModel()->code];
                }
            };

            $hint = strtr("<p>{text}</p>", [
                '{text}' => MailModule::t('Available variables')
            ]);

            $hint .= '<ul>';
            foreach (Mindy::app()->mail->formatData($codes) as $code => $name) {
                $hint .= strtr("<li>{text}</li>", [
                    '{text}' => $code . ' - ' . $name
                ]);
            }
            $hint .= '</ul>';
        }

        $fields = [
            'code' => [
                'class' => CharField::class,
            ],
            'subject' => [
                'class' => CharField::class,
                'hint' => $hint
            ],
            'message' => [
                'class' => TextField::class,
                'widget' => new CodeMirrorWidget()
            ],
            'template' => [
                'class' => CharField::class,
            ],
        ];

        if (Mindy::app()->user && Mindy::app()->user->is_superuser) {
            $fields['is_locked'] = CheckboxField::class;
        }

        return $fields;
    }

    public function getModel()
    {
        return new MailTemplate;
    }
}
