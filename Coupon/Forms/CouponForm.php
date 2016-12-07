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
 * @date 21/08/14.08.2014 19:34
 */

namespace Modules\Coupon\Forms;


use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;
use Modules\Coupon\Models\Coupon;

class CouponForm extends ModelForm
{
    public function getModel()
    {
        return Coupon::className();
    }

    public function send()
    {
        return Mindy::app()->mail->fromCode('coupon.send', $this->cleanedData['email'], [
            'data' => $this->cleanedData
        ]);
    }
}
