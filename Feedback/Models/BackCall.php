<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 19/04/16
 * Time: 17:31
 */

namespace Modules\Feedback\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Model;

class BackCall extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'phone' => [
                'class' => CharField::class,
                'verboseName' => self::t('Phone')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'editable' => false,
                'verboseName' => self::t('Created at')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}