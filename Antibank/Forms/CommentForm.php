<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 16/09/14
 * Time: 15:39
 */

namespace Modules\Antibank\Forms;

use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\Fields\TextField;
use Modules\Comments\Forms\CommentForm as DefaultCommentForm;

class CommentForm extends DefaultCommentForm
{
    public function getFields()
    {
        return array_merge(parent::getFields(), [
            'username' => [
                'class' => TextField::className(),
                'html' => [
                    'placeholder' => 'Ваше имя'
                ]
            ],
            'email' => [
                'class' => TextField::className(),
                'html' => [
                    'placeholder' => 'Ваш email'
                ]
            ],
            'comment' => [
                'class' => TextareaField::className(),
                'html' => [
                    'placeholder' => 'Комментарий'
                ]
            ]
        ]);
    }
}