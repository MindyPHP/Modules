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
 * @date 30/10/14.10.2014 15:30
 */

namespace Modules\Promo\Models;

use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Model;
use Mindy\Validation\UniqueValidator;
use Modules\Promo\PromoModule;

class Promo extends Model
{
    public static function getFields()
    {
        return [
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => PromoModule::t('Email'),
                'validators' => [
                    new UniqueValidator(PromoModule::t("You are already subscribed"))
                ],
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->email;
    }
}
