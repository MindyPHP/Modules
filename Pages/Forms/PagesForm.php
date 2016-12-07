<?php

namespace Modules\Pages\Forms;

use Mindy\Form\Fields\SelectField;
use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Files\Fields\FilesField;
use Modules\Pages\Models\Page;
use Modules\Pages\PagesModule;

/**
 * Class PagesForm
 * @package Modules\Pages
 */
class PagesForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            PagesModule::t('Main information') => [
                'name', 'url', 'parent', 'is_index', 'is_published'
            ],
            PagesModule::t('Content') => [
                'content_short', 'content'
            ],
            PagesModule::t('Additional') => [
                'published_at', 'file'
            ],
            PagesModule::t('Display settings') => [
                'view', 'view_children', 'sorting'
            ]
        ];
    }

    public function getFields()
    {
        return [
            'parent' => [
                'class' => SelectField::class,
                'choices' => function() {
                    $model = $this->getModel();

                    $list = ['' => ''];

                    $qs = $model->objects()->order(['root', 'lft']);
                    $parents = $qs->all();
                    foreach ($parents as $model) {
                        $level = $model->level ? $model->level - 1 : $model->level;
                        $list[$model->pk] = $level ? str_repeat("—", $level) . ' ' . $model->name : $model->name;
                    }
                    return $list;
                }
            ],
            'sorting' => [
                'class' => SelectField::class,
            ],
            'content_short' => [
                'class' => UEditorField::class,
                'label' => PagesModule::t('Short content')
            ],
            'content' => [
                'class' => UEditorField::class,
                'label' => PagesModule::t('Content')
            ],
            'view' => [
                'class' => SelectField::class,
                'choices' => Page::getViews(),
                'label' => PagesModule::t('View')
            ],
            'view_children' => [
                'class' => SelectField::class,
                'choices' => Page::getViews(),
                'hint' => PagesModule::t('View for children pages'),
                'label' => PagesModule::t('View children')
            ],
            'documents' => [
                'class' => FilesField::class,
                'template' => "pages/fields/files.html"
            ]
        ];
    }

    public function getModel()
    {
        return new Page;
    }
}
