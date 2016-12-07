<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\User\Models\User;
use Modules\User\Helpers\UserHelper;

class ActivationKey extends Model
{
    public static function getFields()
    {
        return [
            'key' => [
                'class' => CharField::class,
                'verboseName' => self::t('Activation key'),
                'editable' => false
            ],
            'type' => [
                'class' => CharField::class,
                'verboseName' => self::t('Key type'),
                'editable' => false,
                'choices' => [
                    'email' => 'email',
                    'sms' => 'sms'
                ]
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'verboseName' => self::t('Created at'),
                'autoNowAdd' => true,
                'editable' => false
            ],
            'user' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'verboseName' => self::t('User'),
                'editable' => false
            ],
            'is_active' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is active'),
                'editable' => false,
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->key;
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->key = UserHelper::generateActivationKey($owner->type == 'sms');
        }
    }

    public function afterSave($owner, $isNew)
    {
        /** @var ActivationKey $owner */
        if ($isNew) {
            if ($owner->is_active) {
                /**
                 * Избежание дубликатов активных ключей
                 * Возможен только 1 ключ для каждого типа
                 */
                self::objects()
                    ->filter(['type' => $owner->type, 'user' => $owner->user])
                    ->exclude(['id' => $owner->id])
                    ->delete();
            }
        }
    }
}