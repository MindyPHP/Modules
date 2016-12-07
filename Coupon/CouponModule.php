<?php

namespace Modules\Coupon;

use Mindy\Base\Module;

class CouponModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Coupons'),
                    'adminClass' => 'CouponAdmin',
                ]
            ]
        ];
    }
}
