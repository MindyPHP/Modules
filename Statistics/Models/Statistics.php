<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 12/05/16 09:36
 */

namespace Modules\Statistics\Models;

use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\IpField;
use Mindy\Orm\Model;

class Statistics extends Model
{
    public static function getFields()
    {
        return [
            'user_agent' => [
                'class' => TextField::class,
                'editable' => false,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'verboseName' => self::t('Created at'),
                'autoNowAdd' => true,
                'editable' => false,
            ],
            'ip_address' => [
                'class' => IpField::class,
                'verboseName' => self::t('Ip address'),
                'editable' => false,
            ],
            'url' => [
                'class' => CharField::class,
                'verboseName' => self::t('Url'),
                'editable' => false
            ]
        ];
    }
}