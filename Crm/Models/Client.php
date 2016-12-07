<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 02/10/14
 * Time: 14:34
 */

namespace Modules\Crm\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Model;
use Modules\Crm\CrmModule;

class Client extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => CrmModule::t('Client name'),
                'required' => true,
            ],
        ];
    }

    public function __toString()
    {
        return $this->name;
    }
} 