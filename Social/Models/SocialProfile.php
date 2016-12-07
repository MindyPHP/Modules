<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 07/11/14.11.2014 23:22
 */

namespace Modules\Social\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\JsonField;
use Mindy\Orm\Model;
use Modules\Social\SocialModule;
use Modules\User\Models\User;

class SocialProfile extends Model
{
    public static function getFields()
    {
        return [
            'social_id' => [
                'class' => CharField::className(),
                'verboseName' => SocialModule::t('Social id'),
                'null' => false,
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'null' => false,
                'verboseName' => SocialModule::t('User'),
            ],
            'info' => [
                'class' => JsonField::className(),
                'null' => false,
                'verboseName' => SocialModule::t('User information from social network'),
            ],
            'provider' => [
                'class' => CharField::className(),
                'null' => false,
                'verboseName' => SocialModule::t('Social provider'),
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->social_id;
    }
}
