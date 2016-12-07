<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 15/04/16
 * Time: 20:28
 */

namespace Modules\Feedback\Models;

use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Model;

class Feedback extends Model
{
    public static function getFields()
    {
        return [
            'subject' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Subject'),
            ],
            'email' => [
                'class' => EmailField::class,
                'verboseName' => self::t('Email'),
                'required' => true,
            ],
            'phone' => [
                'class' => CharField::class,
                'verboseName' => self::t('Phone'),
                'required' => true,
            ],
            'message' => [
                'class' => TextField::class,
                'verboseName' => self::t('Message'),
                'required' => true,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'editable' => false,
            ],
        ];
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = self::t('Messages');
        return $names;
    }
}