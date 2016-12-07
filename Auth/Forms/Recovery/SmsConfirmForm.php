<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms\Recovery;

use Mindy\Form\Form;
use Mindy\Form\Fields\CharField;
use Mindy\Validation\MinLengthValidator;
use Mindy\Validation\RequiredValidator;
use Modules\Auth\AuthModule;
use Modules\Auth\Models\LostPasswordKey;

class SmsConfirmForm extends Form
{
    public function getFields()
    {
        return [
            'code' => [
                'class' => CharField::class,
                'label' => AuthModule::t('Code from SMS message'),
                'validators' => [
                    new MinLengthValidator(4),
                    new RequiredValidator(),
                    function ($value) {
                        $count = LostPasswordKey::objects()->filter([
                            'key' => $value,
                            'is_active' => true
                        ])->count();
                        if ($count == 0) {
                            return AuthModule::t("Incorrect activation key");
                        }
                        return true;
                    }
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->code->getValue();
    }
}