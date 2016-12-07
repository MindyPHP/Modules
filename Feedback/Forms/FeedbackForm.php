<?php

namespace Modules\Feedback\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\TextAreaField;
use Modules\Feedback\FeedbackModule;
use Modules\Feedback\Models\Feedback;

class FeedbackForm extends BaseFeedbackForm
{
    public $templateCode = 'feedback.simple';

    public function getFields()
    {
        return [
            'subject' => [
                'class' => CharField::class,
                'required' => true,
                'label' => FeedbackModule::t('Subject'),
                'html' => [
                    'placeholder' => FeedbackModule::t('Subject'),
                ]
            ],
            'email' => [
                'class' => EmailField::class,
                'label' => FeedbackModule::t('Email'),
                'required' => true,
                'html' => [
                    'placeholder' => FeedbackModule::t('Email'),
                ]
            ],
            'phone' => [
                'class' => CharField::class,
                'label' => FeedbackModule::t('Phone'),
                'required' => true,
                'html' => [
                    'placeholder' => FeedbackModule::t('Phone'),
                ]
            ],
            'message' => [
                'class' => TextAreaField::class,
                'label' => FeedbackModule::t('Message'),
                'required' => true,
                'html' => [
                    'placeholder' => FeedbackModule::t('Message'),
                ]
            ]
        ];
    }

    public function save()
    {
        $attributes = [];
        foreach ($this->getFieldsInit() as $name => $field) {
            $attributes[$name] = $field->getValue();
        }

        $model = new Feedback($attributes);
        if ($model->save()) {
            return $this->send();
        }

        return false;
    }
}
