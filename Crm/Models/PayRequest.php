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
 * @date 03/10/14 14:20
 */
namespace Modules\Crm\Models;

use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Crm\CrmModule;

class PayRequest extends Model
{
    const STATUS_SENT = 1;
    const STATUS_RECEIVED = 2;

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
                'verboseName' => CrmModule::t('Month of request')
            ],
            'year' => [
                'class' => IntField::className(),
                'verboseName' => CrmModule::t('Year of request')
            ],
            'status' => [
                'class' => IntField::className(),
                'choices' => [
                    self::STATUS_SENT => CrmModule::t('Request sent'),
                    self::STATUS_RECEIVED => CrmModule::t('Request received')
                ],
                'default' => self::STATUS_SENT
            ],
            'updated_at' => [
                'class' => DatetimeField::className(),
                'autoNow' => true,
                'verboseName' => CrmModule::t('Updated at'),
                'null' => true
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