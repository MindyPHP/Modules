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
 * @date 30/10/14.10.2014 15:29
 */

namespace Modules\Promo\Forms;

use Mindy\Form\Fields\EmailField;
use Mindy\Form\ModelForm;
use Modules\Promo\Models\Promo;
use Modules\Promo\PromoModule;

class SubscribeForm extends ModelForm
{
    public function getFields()
    {
        return [
            'email' => [
                'class' => EmailField::className(),
                'html' => [
                    'placeholder' => PromoModule::t('Email address')
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new Promo;
    }
}
