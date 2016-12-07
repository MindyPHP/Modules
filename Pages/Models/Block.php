<?php

namespace Modules\Pages\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Pages\PagesModule;

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 18/04/14.04.2014 20:08
 */

/**
 * Class Block
 * @package Modules\Pages
 */
class Block extends Model
{
    public static function getFields()
    {
        return [
            'slug' => [
                'class' => CharField::className(),
                'verboseName' => PagesModule::t('Slug')
            ],
            'name' => [
                'class' => CharField::className(),
                'verboseName' => PagesModule::t('Name block')
            ],
            'content' => [
                'class' => TextField::className(),
                'verboseName' => PagesModule::t('Content')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAdminNames($instance = null)
    {
        $module = $this->getModule();
        $name = 'text block';
        if ($instance) {
            $updateTranslate = $module->t('Update ' . $name . ': {name}', ['{name}' => (string)$instance]);
        } else {
            $updateTranslate = $module->t('Update ' . $name);
        }
        return [
            $module->t(ucfirst($name . 's')),
            $module->t('Create ' . $name),
            $updateTranslate,
        ];
    }
}
