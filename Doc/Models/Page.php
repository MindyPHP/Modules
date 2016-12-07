<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 20/01/15 15:25
 */

namespace Modules\Doc\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\MarkdownField;
use Mindy\Orm\TreeModel;
use Modules\Doc\DocModule;

class Page extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => DocModule::t('Name')
            ],
            'url' => [
                'class' => CharField::className(),
                'verboseName' => DocModule::t('Url')
            ],
            'content' => [
                'class' => MarkdownField::className(),
                'null' => true,
                'verboseName' => DocModule::t('Content')
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'verboseName' => DocModule::t('Created at'),
                'autoNowAdd' => true
            ]
        ]);
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('doc:view', ['url' => $this->url]);
    }
}
