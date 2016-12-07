<?php

namespace Modules\User\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Form;
use Mindy\Helper\Params;
use Modules\User\Models\User;
use Modules\User\UserModule;

/**
 * Class RecoverForm
 * @package Modules\User
 */
class RecoverForm extends Form
{
    /** @var \Modules\User\Models\User */
    private $_model;

    public function getFields()
    {
        return [
            'username_or_email' => [
                'class' => CharField::className(),
                'label' => UserModule::t('Email')
            ]
        ];
    }

    public function cleanUsername_or_email()
    {
        $field = strpos($this->username_or_email->getValue(), "@") ? 'email' : 'username';
        $this->_model = User::objects()->get([
            $field => $this->username_or_email->getValue()
        ]);

        if ($this->_model === null) {
            $this->username_or_email->addError(UserModule::t('User not found'));
        }

        return $this->_model;
    }

    public function send()
    {
        if ($this->_model && $this->_model->objects()->changeActivationKey()) {
            $app = Mindy::app();
            $recoverUrl = $app->urlManager->reverse('user:recover_activate', [
                'key' => $this->_model->activation_key
            ]);
            return $app->mail->fromCode('user.recover', $this->_model->email, [
                'data' => $this->_model,
                'username' => $this->_model->username,
                'site' => $app->getModule('Sites')->getSite(),
                'activation_url' => $app->request->http->absoluteUrl($recoverUrl),
            ]);
        }

        return false;
    }
}
