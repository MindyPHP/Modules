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
 * @date 17/02/15 15:23
 */
namespace Modules\Tour\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Tour\TourModule;

class Order extends Model
{
    public static function getFields() 
    {
        return [
            'event' => [
                'class' => ForeignField::className(),
                'verboseName' => TourModule::t('Event'),
                'modelClass' => Event::className(),
            ],
            'organization' => [
                'class' => CharField::className(),
                'verboseName' => TourModule::t('Organization')
            ],
            'users' => [
                'class' => CharField::className(),
                'verboseName' => TourModule::t('Count of users')
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => TourModule::t('Your phone')
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => TourModule::t('Your e-mail'),
                'null' => true
            ],
            'text' => [
                'class' => TextField::className(),
                'verboseName' => TourModule::t('Comment'),
                'null' => true
            ],
            'created_at' => [
                'class' => DatetimeField::className(),
                'verboseName' => TourModule::t('Created at'),
                'null' => true,
                'editable' => false,
                'autoNowAdd' => true
            ],
        ];
    }
    
    public function __toString() 
    {
        return parent::__toString();
    }
} 