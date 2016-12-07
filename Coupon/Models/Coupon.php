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
 * @date 27/08/14.08.2014 17:05
 */

namespace Modules\Coupon\Models;


use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Model;
use Modules\Coupon\CouponModule;

class Coupon extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => CouponModule::t('Name')
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => CouponModule::t('Email')
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => CouponModule::t('Phone')
            ],
            'coupon' => [
                'class' => CharField::className(),
                'verboseName' => CouponModule::t('Coupon')
            ]
        ];
    }

    public function __toString()
    {
        return (string) $this->coupon;
    }

    public function save(array $fields = [])
    {
        $this->coupon = substr(md5(time()), 0, 5);
        return parent::save($fields);
    }
}
