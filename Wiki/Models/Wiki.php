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
 * @date 30/10/14.10.2014 17:33
 */

namespace Modules\Wiki\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\MarkdownField;
use Mindy\Orm\Model;
use Modules\Wiki\WikiModule;

class Wiki extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => WikiModule::t('Name')
            ],
            'url' => [
                'class' => CharField::className(),
                'verboseName' => WikiModule::t('Url'),
                'unique' => true
            ],
            'content' => [
                'class' => MarkdownField::className(),
                'verboseName' => WikiModule::t('Content')
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'editable' => false
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'editable' => false
            ],
            'is_complete' => [
                'class' => BooleanField::className(),
                'verboseName' => WikiModule::t('Is complete')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('wiki:view', ['url' => $this->url]);
    }
}
