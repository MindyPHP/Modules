<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 17:17
 */

namespace Modules\Auth\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\User\Models\User;

class Token extends Model
{
    public static function getFields()
    {
        return [
            'key' => [
                'class' => CharField::class,
                'verboseName' => self::t('Key'),
                'editable' => false
            ],
            'user' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'verboseName' => self::t('User'),
                'editable' => false
            ]
        ];
    }
}