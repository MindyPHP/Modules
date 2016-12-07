<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/01/15 14:47
 */

namespace Modules\Forum\Models;

use Mindy\Orm\Fields\FileField;
use Mindy\Orm\Model;
use Modules\Forum\ForumModule;

class TopicAttachment extends Model
{
    public static function getFields()
    {
        return [
            'file' => [
                'class' => FileField::className(),
                'verboseName' => ForumModule::t('File')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->file->getUrl();
    }
}
