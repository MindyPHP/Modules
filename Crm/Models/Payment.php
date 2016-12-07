<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 03/10/14 09:20
 */
namespace Modules\Crm\Models;

use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Crm\CrmModule;

class Payment extends Model
{
    public static function getFields() 
    {
        return [
            'subscribe' => [
                'class' => ForeignField::className(),
                'modelClass' => Subscribe::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Subscribe')
            ],
            'month' => [
                'class' => IntField::className(),
                'verboseName' => CrmModule::t('Month of pay')
            ],
            'year' => [
                'class' => IntField::className(),
                'verboseName' => CrmModule::t('Year of pay')
            ],
            'created_at' => [
                'class' => DatetimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => CrmModule::t('Created at')
            ]
        ];
    }
    
    public function __toString() 
    {
        return $this->month . '.' . $this->year;
    }

    public static function monthCollected($month, $year)
    {
        return self::objects()->filter(['year' => $year, 'month' => $month])->sum('subscribe__price');
    }

    public static function prepared(array $filter = [])
    {
        $payments = self::objects()->filter($filter)->asArray()->all();
        $prepared = [];
        foreach ($payments as $payment) {
            $subscribe = $payment['subscribe_id'];
            if (!isset($prepared[$subscribe])) {
                $prepared[$subscribe] = [];
            }
            $date = $payment['year'] . '-' . str_pad($payment['month'], 2, '0', STR_PAD_LEFT);
            $prepared[$subscribe][$date] = $payment;
        }
        return $prepared;
    }
} 