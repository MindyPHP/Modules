<?php

namespace Modules\Blog\Forms;

use Mindy\Form\Fields\DropDownField;
use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Blog\BlogModule;
use Modules\Blog\Models\Post;

/**
 * Class PostForm
 */
class PostForm extends ModelForm
{
    public $exclude = ['comments'];

    public function getFieldsets()
    {
        return [
            BlogModule::t('Main information') => [
                'name', 'slug', 'content_short', 'content', 'category',
                'view', 'is_published', 'published_at', 'file'
            ],
            BlogModule::t('Comments settings') => [
                'enable_comments', 'enable_comments_form'
            ]
        ];
    }

    public function getFields()
    {
        $model = $this->getModel();
        return [
            'content_short' => [
                'class' => TextAreaField::className(),
                'label' => BlogModule::t('Short content')
            ],
            'content' => [
                'class' => UEditorField::className(),
                'label' => BlogModule::t('Content')
            ],
            'view' => [
                'class' => DropDownField::className(),
                'choices' => $model->getViews(),
                'label' => BlogModule::t('View')
            ],
        ];

    }

    public function getModel()
    {
        return new Post;
    }
}
