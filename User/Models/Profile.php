<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 17:09
 */

namespace Modules\User\Models;

use Mindy\Orm\Fields\OneToOneField;
use Mindy\Orm\Model;

class Profile extends Model
{
    public static function getFields()
    {
        return [
            'user' => [
                'class' => OneToOneField::class,
                'modelClass' => User::class,
                'editable' => false,
                'verboseName' => self::t('User')
            ]
        ];
    }
}