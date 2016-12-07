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
 * @date 14/10/14.10.2014 18:19
 */

namespace Modules\Forum\Forms;

use Mindy\Form\ModelForm;
use Modules\Forum\Fields\AttachmentsField;
use Modules\Forum\ForumModule;
use Modules\Forum\Models\Topic;

class TopicForm extends ModelForm
{
    public $exclude = ['forum', 'is_locked', 'is_sticky', 'is_closed'];

    public function getFieldsets()
    {
        return [
            ForumModule::t('Information') => ['title', 'message'],
            // ForumModule::t('Attachments') => ['files'],
        ];
    }

    /*
    public function getFields()
    {
        return [
            'files' => [
                'class' => AttachmentsField::className(),
                'label' => ForumModule::t('Attachments')
            ]
        ];
    }
    */

    public function getModel()
    {
        return new Topic;
    }
}
