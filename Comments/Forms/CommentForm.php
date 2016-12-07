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
 * @date 11/09/14.09.2014 14:44
 */

namespace Modules\Comments\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\HiddenField;
use Mindy\Form\Fields\RecaptchaField;
use Mindy\Form\ModelForm;
use Mindy\Locale\Translate;
use Mindy\Validation\RequiredValidator;

class CommentForm extends ModelForm
{
    public $model;

    public $toLink;

    public $exclude = ['is_spam', 'is_published', 'user', 'created_at', 'updated_at'];

    public function getFields()
    {
        $module = Mindy::app()->getModule('Comments');
        return array_merge(parent::getFields(), [
            'parent' => [
                'class' => HiddenField::className()
            ],
            'captcha' => [
                'class' => RecaptchaField::className(),
                'label' => Translate::getInstance()->t('validation', 'Captcha'),
                'publicKey' => $module->recaptchaPublicKey,
                'secretKey' => $module->recaptchaSecretKey
            ]
        ]);
    }

    public function initFields()
    {
        parent::initFields();
        if (Mindy::app()->user->isGuest) {
            foreach (['username', 'email'] as $name) {
                $this->_fields[$name]->required = true;
                $this->_fields[$name]->validators[] = new RequiredValidator();
            }
        }
    }

    public function init()
    {
        $meta = $this->getModel()->getMeta();
        $this->exclude[] = $meta->getForeignField($this->getModel()->getRelation())->name;
        if (Mindy::app()->user->isGuest === false) {
            $this->exclude = array_merge($this->exclude, ['username', 'email', 'captcha']);
        }
        $module = Mindy::app()->getModule('Comments');
        if (empty($module->recaptchaPublicKey) && empty($module->recaptchaSecretKey)) {
            $this->exclude = array_merge($this->exclude, ['captcha']);
        }
        parent::init();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function save()
    {
        $saved = parent::save();
        Mindy::app()->mail->fromCode('comments.new_comment', Mindy::app()->managers, [
            'data' => $this->getInstance()
        ]);
        return $saved;
    }
}
