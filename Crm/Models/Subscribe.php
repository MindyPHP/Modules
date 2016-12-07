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
 * @date 03/10/14 09:06
 */
namespace Modules\Crm\Models;

use Mindy\Orm\Fields\DateField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Crm\CrmModule;
use DateTime;

class Subscribe extends Model
{
    public static function getFields() 
    {
        return [
            'project' => [
                'class' => ForeignField::className(),
                'modelClass' => Project::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Client')
            ],
            'from' => [
                'class' => DateField::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Subscribe from')
            ],
            'to' => [
                'class' => DateField::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Subscribe to')
            ],
            'months' => [
                'class' => DateField::className(),
                'verboseName' => CrmModule::t('Months')
            ],
            'price' => [
                'class' => DecimalField::className(),
                'precision' => 10,
                'scale' => 2
            ],
            'num_from' => [
                'class' => IntField::className(),
                'verboseName' => CrmModule::t('Number of account from'),
                'default' => 1
            ]
        ];
    }
    
    public function __toString() 
    {
        return $this->project->name;
    }

    public function beforeSave($owner, $isNew)
    {
        $from = new DateTime($owner->from);
        $to = new DateTime($owner->to);
        $owner->months = $to->diff($from)->m + 1;
    }

    public static function monthExpected($month, $year)
    {
        $date = new DateTime();
        $date->setDate($year, $month, 1);
        return self::objects()
            ->filter(['to__gte' => $date->format('Y-m-01'), 'from__lte' => $date->format('Y-m-t')])->sum('price');
    }
} 